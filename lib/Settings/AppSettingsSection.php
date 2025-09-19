<?php

namespace OCA\RdsNg\Settings;

use OCP\App\IAppManager;
use OCP\IURLGenerator;
use OCP\Settings\IIconSection;

use OCA\RdsNg\AppInfo\Application;

class AppSettingsSection implements IIconSection
{
    private IURLGenerator $urlGenerator;

    private string $appName;

    public function __construct(IURLGenerator $urlGenerator, IAppManager $appManager)
    {
        $this->urlGenerator = $urlGenerator;

        $this->appName = $appManager->getAppInfo(Application::APP_ID)["name"];
    }

    public function getID(): string
    {
        return Application::APP_ID;
    }

    public function getName(): string
    {
        return $this->appName;
    }

    public function getPriority(): int
    {
        return 70;
    }

    public function getIcon(): string
    {
        return $this->urlGenerator->imagePath(Application::APP_ID, 'app-bl.svg');
    }
}
