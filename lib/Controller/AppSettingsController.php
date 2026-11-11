<?php

namespace OCA\RdsNg\Controller;

use OCA\RdsNg\AppInfo\Application;
use OCA\RdsNg\Settings\AppSettings;
use OCA\RdsNg\Utility\URLUtils;
use OCP\AppFramework\{
    Controller,
    Http\Attribute\FrontpageRoute,
    Http\Attribute\NoAdminRequired,
    Http\Attribute\NoCSRFRequired,
    Http\DataResponse,
    Http
};
use OCP\IRequest;

class AppSettingsController extends Controller
{
    private AppSettings $appSettings;

    public function __construct(
        IRequest    $request,
        AppSettings $appSettings
    )
    {
        parent::__construct(Application::APP_ID, $request);

        $this->appSettings = $appSettings;
    }

    /*** Page endpoints ***/

    #[NoAdminRequired]
    #[FrontpageRoute(verb: "PUT", url: "/settings")]
    public function rdsAppSettings(string $appUrl, string $domoUrl, string $instanceId, string $apiKey): DataResponse
    {
        $this->appSettings->setAppURL($appUrl);
        $this->appSettings->setDomoURL($domoUrl);
        $this->appSettings->setInstanceID($instanceId);
        $this->appSettings->setAPIKey($apiKey);
        return new DataResponse("", Http::STATUS_OK);
    }
}
