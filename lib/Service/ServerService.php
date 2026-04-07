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

    public function deleteUser(string $email): void
    {
        if ($email == "") {
            throw new \Exception("User email address missing");
        }

        // TODO: Build & pass call data: DeleteUserCmd + Email + InstanceID
        $this->callServerAPI();
    }

    private function callServerAPI(): void
    {
        $serverAddress = $this->appSettings->getServerURL();
        if ($serverAddress == "") {
            throw new \Exception("Server address missing");
        }

        $apiKey = $this->appSettings->getApiKey();
        if ($apiKey == "") {
            throw new \Exception("Api key missing");
        }

        // TODO: Append API Key to msg
    }
}
