<?php

namespace OCA\RdsNg\Service;

use OCA\RdsNg\Settings\AppSettings;

class ServerService
{
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

        // TODO: Issue message
        throw new \Exception(json_encode($msg));
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
}
