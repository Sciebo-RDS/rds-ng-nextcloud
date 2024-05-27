<?php

namespace OCA\RdsNg\Utility;

use OCP\IConfig;

class URLUtils
{
    public static function getHostURL(IConfig $config, string $endpoint = ""): string
    {
        $host = $_SERVER["HTTP_HOST"];
        $protocol = !empty($_SERVER["HTTPS"]) ? "https" : "http";

        $url = $config->getSystemValue("overwriteprotocol", $protocol) . "://" . $config->getSystemValue("overwritehost", $host);
        if ($endpoint != "") {
            if (!str_ends_with($url, "/") && !str_starts_with($endpoint, "/")) {
                $url .= "/";
            }
            $url .= $endpoint;
        }
        return $url;
    }
}
