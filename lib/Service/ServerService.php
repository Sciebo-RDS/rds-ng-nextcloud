<?php

namespace OCA\RdsNg\Service;

use OCA\RdsNg\Settings\AppSettings;

class ServerService
{
    const API_VERSION = "v1";

    private AppSettings $appSettings;

    public function __construct(AppSettings $appSettings)
    {
        $this->appSettings = $appSettings;
    }

    public function deleteUser(string $userID): void
    {
        if ($userID == "") {
            throw new \Exception("User ID missing");
        }

        $this->callServerAPI("command/user/delete", ["user_id" => $userID, "host_id" => $this->appSettings->getInstanceID()], true);
    }

    private function callServerAPI(string $name, array $data = [], bool $isProtected = false): void
    {
        $serverAddress = $this->appSettings->getServerURL();
        if ($serverAddress == "") {
            throw new \Exception("Server address missing");
        }

        $msg = $this->buildMessage($name, $data, $isProtected);

        // POST request via cURL and check the result
        $curl = curl_init($serverAddress . "/api/" . ServerService::API_VERSION);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($msg));
        curl_setopt($curl, CURLOPT_HTTPHEADER, ["Content-Type: application/json", "X-RDS-NG-API-Key: " . $this->appSettings->getAPIKey()]);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($curl);
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($statusCode >= 400) {
            throw new \Exception("API call failed with status code {$statusCode}: {$this->getErrorMessage($result)}");
        }
    }

    private function buildMessage(string $name, array $data, bool $addAPIKey = false): array
    {
        $appID = "web/integration/{$this->appSettings->getInstanceID()}";
        $msg = [
            "name" => $name,
            "origin" => $appID,
            "sender" => $appID,
            "target" => "infra/server/default"
        ];
        if ($addAPIKey) {
            $apiKey = $this->appSettings->getApiKey();
            if ($apiKey == "") {
                throw new \Exception("API key missing");
            }
            $msg = array_merge($msg, ["api_key" => $apiKey]);
        }
        return array_merge($msg, $data);
    }

    private function getErrorMessage(string $result): string
    {
        try {
            $jsonData = json_decode($result, true);

            if ($jsonData && array_key_exists("message", $jsonData)) {
                return $jsonData["message"];
            }
        } catch (\Exception $e) {
        }
        return $result;
    }
}
