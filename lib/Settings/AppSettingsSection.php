<?php

namespace OCA\RdsNg\Settings;

use OCP\IURLGenerator;
use OCP\Settings\IIconSection;

use OCA\RdsNg\AppInfo\Application;

class AppSettingsSection implements IIconSection
{
    private IURLGenerator $urlGenerator;

    public function __construct(IURLGenerator $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function getID(): string
    {
        return Application::APP_ID;
    }

    public function getName(): string
    {
        return "BridgIT";
    }

    public function getPriority(): int
    {
        return 70;
    }

    public function getIcon()
    {
        return $this->urlGenerator->imagePath(Application::APP_ID, 'app-bl.svg');
    }
}
