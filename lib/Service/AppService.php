<?php

namespace OCA\RdsNg\Service;

use OCA\RdsNg\Settings\AppSettings;

class AppService
{
    private AppSettings $settings;

    public function __construct(AppSettings $settings)
    {
        $this->settings = $settings;
    }

    public function getAppHost(bool $includePort = false): string
    {
        $url = $this->settings->getAppURL();
        if ($url == "") {
            return "";
        }

        $port = parse_url($url, PHP_URL_PORT);
        $host = parse_url($url, PHP_URL_HOST);

        if ($includePort && $port != null) {
            return "$host:$port";
        }
        return $host;
    }

    public function normalizeUserID(string $uid): string
    {
        $instanceID = $this->settings->getInstanceID();
        if ($instanceID == "") {
            $instanceID = "default";
        }
        return $uid . '::' . $instanceID;
    }

    public function settings(): AppSettings
    {
        return $this->settings;
    }
}
