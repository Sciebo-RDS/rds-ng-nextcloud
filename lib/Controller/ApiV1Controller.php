<?php

namespace OCA\RdsNg\Controller;

use OCA\RdsNg\AppInfo\Application;
use OCA\RdsNg\Settings\AppSettings;
use OCA\RdsNg\Utility\URLUtils;

use OCP\AppFramework\{ApiController, Http\DataResponse};
use OCP\IConfig;
use OCP\IRequest;

class ApiV1Controller extends ApiController
{
    private IConfig $config;

    private AppSettings $appSettings;

    public function __construct(IRequest $request, IConfig $config, AppSettings $appSettings)
    {
        parent::__construct(Application::APP_ID, $request);

        $this->config = $config;

        $this->appSettings = $appSettings;
    }

    /**
     * @PublicPage
     * @NoCSRFRequired
     * @CORS
     */
    public function publicKey(): DataResponse
    {
        return new DataResponse(["public-key" => $this->appSettings->getUserTokenPublicKey()]);
    }

    /**
     * @PublicPage
     * @NoCSRFRequired
     * @CORS
     */
    public function authorization(): DataResponse
    {
        return new DataResponse(["authorization" => [
            "type" => "oauth2",
            "config" => [
                "endpoints" => [
                    "authorization" => URLUtils::getHostURL($this->config, "/apps/oauth2/authorize"),
                    "token" => URLUtils::getHostURL($this->config, "/apps/oauth2/api/v1/token"),
                ]
            ]
        ]]);
    }
}
