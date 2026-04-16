<?php

namespace OCA\RdsNg\Service;

use OCA\RdsNg\Settings\AppSettings;

class CommandService
{
    private AppService $appService;

    public function __construct(AppService $appService)
    {
        $this->appService = $appService;
    }

    public function deleteUser(string $userID): void
    {
        if ($userID == "") {
            throw new \Exception("User ID missing");
        }

        $this->callDomoCommand("user", $this->getCommandData(["user_id" => $userID]), "DELETE");
    }

    private function callDomoCommand(string $endpoint, array $data = [], string $method = "POST"): void
    {
        $domoURL = $this->appService->settings()->getDomoURL();
        if ($domoURL == "") {
            throw new \Exception("Domo URL missing");
        }

        // Send request via cURL and check the result
        $curl = curl_init("{$domoURL}/command/{$endpoint}");
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_HTTPHEADER, ["Content-Type: application/json", "X-RDS-NG-API-Key: " . $this->appService->settings()->getAPIKey()]);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($curl);
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($statusCode >= 400) {
            throw new \Exception("API call failed with status code {$statusCode}: {$this->getErrorMessage($result)}");
        }
    }

    private function getCommandData(array $data): array
    {
        $defaultData = ["instance_id" => $this->appService->settings()->getInstanceID()];
        return array_merge($defaultData, $data);
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
