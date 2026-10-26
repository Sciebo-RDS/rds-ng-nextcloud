<?php

namespace OCA\RdsNg\Settings;

use OCA\RdsNg\AppInfo\Application;
use OCA\RdsNg\Types\KeyPair;

use OCP\AppFramework\Http\TemplateResponse;
use OCP\AppFramework\Services\IInitialState;
use OCP\IAppConfig;
use OCP\IConfig;
use OCP\Settings\ISettings;

class AppSettings implements ISettings
{
    const SETTING_APP_URL = "app_url";
    const SETTING_DOMO_URL = "domo_url";

    const SETTING_INSTANCE_ID = "instance_id";

    const SETTING_API_KEY = "api_key";

    const SETTING_USERTOKEN_PUBLIC_KEY = "usertoken_public_key";
    const SETTING_USERTOKEN_PRIVATE_KEY = "usertoken_private_key";

    private IAppConfig $config;

    public function __construct(IAppConfig $config, IInitialState $initialState)
    {
        $this->config = $config;
        $this->initialState = $initialState;
    }

    // TODO: Remove later
    public function getSettings(): array
    {
        return [
            AppSettings::SETTING_APP_URL =>
                $this->config->getValueString(Application::APP_ID, AppSettings::SETTING_APP_URL, ""),
            AppSettings::SETTING_DOMO_URL =>
                $this->config->getValueString(Application::APP_ID, AppSettings::SETTING_DOMO_URL, ""),
            AppSettings::SETTING_INSTANCE_ID =>
                $this->config->getValueString(Application::APP_ID, AppSettings::SETTING_INSTANCE_ID, "default"),
            AppSettings::SETTING_API_KEY =>
                $this->config->getValueString(Application::APP_ID, AppSettings::SETTING_API_KEY, "default"),
            AppSettings::SETTING_USERTOKEN_PUBLIC_KEY =>
                $this->config->getValueString(Application::APP_ID, AppSettings::SETTING_USERTOKEN_PUBLIC_KEY, ""),
            AppSettings::SETTING_USERTOKEN_PRIVATE_KEY =>
                $this->config->getValueString(Application::APP_ID, AppSettings::SETTING_USERTOKEN_PRIVATE_KEY, ""),
        ];
    }

    public function getAppURL(): string
    {
        return $this->config->getValueString(Application::APP_ID, AppSettings::SETTING_APP_URL, "", lazy: true);
    }

    public function setAppURL(string $url): void
    {
        $this->config->setValueString(Application::APP_ID, AppSettings::SETTING_APP_URL, $url, lazy: true);
    }

    public function getDomoURL(): string
    {
        return $this->config->getValueString(Application::APP_ID, AppSettings::SETTING_DOMO_URL, "", lazy: true);
    }

    public function setDomoURL(string $url): void
    {
        $this->config->setValueString(Application::APP_ID, AppSettings::SETTING_DOMO_URL, $url, lazy: true);
    }

    public function getInstanceID(): string
    {
        return $this->config->getValueString(Application::APP_ID, AppSettings::SETTING_INSTANCE_ID, "default", lazy: true);
    }

    public function setInstanceID(string $instanceID): void
    {
        $this->config->setValueString(Application::APP_ID, AppSettings::SETTING_INSTANCE_ID, $instanceID, lazy: true);
    }

    public function getAPIKey(): string
    {
        return $this->config->getValueString(Application::APP_ID, AppSettings::SETTING_API_KEY, "", lazy: true);
    }

    public function setAPIKey(string $apiKey): void
    {
        $this->config->setValueString(Application::APP_ID, AppSettings::SETTING_API_KEY, $apiKey, lazy: true);
    }

    public function getUserTokenPublicKey(): string
    {
        return $this->config->getValueString(Application::APP_ID, AppSettings::SETTING_USERTOKEN_PUBLIC_KEY, "", lazy: true);
    }

    public function getUserTokenPrivateKey(): string
    {
        return $this->config->getValueString(Application::APP_ID, AppSettings::SETTING_USERTOKEN_PRIVATE_KEY, "", lazy: true);
    }

    public function getUserTokenKeys(): KeyPair
    {
        return new KeyPair($this->getUserTokenPublicKey(), $this->getUserTokenPrivateKey());
    }

    public function setUserTokenKeys(KeyPair $keys): void
    {
        $this->config->setValueString(Application::APP_ID, AppSettings::SETTING_USERTOKEN_PUBLIC_KEY, $keys->publicKey());
        $this->config->setValueString(Application::APP_ID, AppSettings::SETTING_USERTOKEN_PRIVATE_KEY, $keys->privateKey());
    }

    public function getForm(): TemplateResponse
    {
        $this->initialState->provideInitialState(AppSettings::SETTING_APP_URL, $this->getAppURL());
        $this->initialState->provideInitialState(AppSettings::SETTING_DOMO_URL, $this->getDomoURL());
        $this->initialState->provideInitialState(AppSettings::SETTING_INSTANCE_ID, $this->getInstanceID());
        $this->initialState->provideInitialState(AppSettings::SETTING_USERTOKEN_PUBLIC_KEY, $this->getUserTokenPublicKey());
        $this->initialState->provideInitialState(AppSettings::SETTING_USERTOKEN_PRIVATE_KEY, $this->getUserTokenPrivateKey());
        return new TemplateResponse(Application::APP_ID, "settings/appsettings", $this->getSettings()); // TODO: Remove settings
    }

    public function getSection(): string
    {
        return Application::APP_ID;
    }

    public function getPriority(): int
    {
        return 70;
    }
}
