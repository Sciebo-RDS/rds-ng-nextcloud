<?php

namespace OCA\RdsNg\Settings;

use OCA\RdsNg\AppInfo\Application;

use OCP\AppFramework\Http\TemplateResponse;
use OCP\IConfig;
use OCP\Settings\ISettings;

class AppSettings implements ISettings {
    const SETTING_APP_URL = "app_url";

    private IConfig $config;

    public function __construct(IConfig $config) {
        $this->config = $config;
    }

    public function getSettings(): array {
        return [
            AppSettings::SETTING_APP_URL => (string)$this->config->getAppValue(Application::APP_ID, AppSettings::SETTING_APP_URL, "")
        ];
    }

    public function getForm(): TemplateResponse {
        return new TemplateResponse(Application::APP_ID, "admin/settings", $this->getSettings());
    }

    public function getSection(): string {
        return Application::APP_ID;
    }

    public function getPriority(): int {
        return 50;
    }
}
