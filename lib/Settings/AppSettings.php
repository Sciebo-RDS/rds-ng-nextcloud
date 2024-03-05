<?php

namespace OCA\RdsNg\Settings;

use OCA\RdsNg\AppInfo\Application;

use OCP\AppFramework\Http\TemplateResponse;
use OCP\IConfig;
use OCP\Settings\ISettings;

class AppSettings implements ISettings {
    const SETTING_APP_URL = "app_url";

    const SETTING_USERID_SUFFIX = "userid_suffix";
    const SETTING_USERID_SUFFIX_ENFORCE = "userid_suffix_enforce";

    const SETTING_USERTOKEN_PUBLIC_KEY = "usertoken_public_key";
    const SETTING_USERTOKEN_PRIVATE_KEY = "usertoken_private_key";

    private IConfig $config;

    public function __construct(IConfig $config) {
        $this->config = $config;
    }

    public function getSettings(): array {
        return [
            AppSettings::SETTING_APP_URL =>
                $this->config->getAppValue(Application::APP_ID, AppSettings::SETTING_APP_URL, ""),
            AppSettings::SETTING_USERID_SUFFIX =>
                $this->config->getAppValue(Application::APP_ID, AppSettings::SETTING_USERID_SUFFIX, ""),
            AppSettings::SETTING_USERID_SUFFIX_ENFORCE =>
                $this->config->getAppValue(Application::APP_ID, AppSettings::SETTING_USERID_SUFFIX_ENFORCE, false) == "true",
            AppSettings::SETTING_USERTOKEN_PUBLIC_KEY =>
                $this->config->getAppValue(Application::APP_ID, AppSettings::SETTING_USERTOKEN_PUBLIC_KEY, ""),
            AppSettings::SETTING_USERTOKEN_PRIVATE_KEY =>
                $this->config->getAppValue(Application::APP_ID, AppSettings::SETTING_USERTOKEN_PRIVATE_KEY, ""),
        ];
    }

    public function getAppURL(): string {
        return $this->getSettings()[self::SETTING_APP_URL];
    }

    public function getUserIDSuffix(): string {
        return $this->getSettings()[self::SETTING_USERID_SUFFIX];
    }

    public function getEnforceUserIDSuffix(): bool {
        return $this->getSettings()[self::SETTING_USERID_SUFFIX_ENFORCE];
    }

    public function getUserTokenPublicKey(): string {
        return $this->getSettings()[self::SETTING_USERTOKEN_PUBLIC_KEY];
    }

    public function getUserTokenPrivateKey(): string {
        return $this->getSettings()[self::SETTING_USERTOKEN_PRIVATE_KEY];
    }

    public function setUserTokenKeys(string $publicKey, string $privateKey): void {
        $this->config->setAppValue(Application::APP_ID, AppSettings::SETTING_USERTOKEN_PUBLIC_KEY, $publicKey);
        $this->config->setAppValue(Application::APP_ID, AppSettings::SETTING_USERTOKEN_PRIVATE_KEY, $privateKey);
    }

    public function getForm(): TemplateResponse {
        return new TemplateResponse(Application::APP_ID, "settings/appsettings", $this->getSettings());
    }

    public function getSection(): string {
        return Application::APP_ID;
    }

    public function getPriority(): int {
        return 70;
    }
}
