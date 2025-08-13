<?php

namespace OCA\RdsNg\Service;

use OCA\RdsNg\Settings\AppSettings;
use OCA\RdsNg\Utility\URLUtils;

class AuthorizationService
{
    private AppSettings $settings;

    public function __construct(AppSettings $settings)
    {
        $this->settings = $settings;
    }

    public function getIssuerURL(string $strategy): string
    {
        return match (strtolower($strategy)) {
            "oauth2" => $this->oauth2IssuerURL(),
            default => throw new \InvalidArgumentException("Unsupported authorization strategy"),
        };
    }

    private function oauth2IssuerURL(): string
    {
        $payload = base64_decode($_GET["state"]);
        $payloadJson = json_decode($payload, true, 512, JSON_THROW_ON_ERROR);
        $isserUrl = parse_url($payloadJson["auth_issuer_url"]);
        return URLUtils::buildURL($isserUrl["scheme"], $isserUrl["host"], $isserUrl["port"], $isserUrl["path"], $_SERVER["QUERY_STRING"]);
    }
}
