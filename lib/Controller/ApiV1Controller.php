<?php

namespace OCA\RdsNg\Controller;

use OCA\RdsNg\AppInfo\Application;
use OCA\RdsNg\Settings\AppSettings;
use OCA\RdsNg\Utility\URLUtils;

use OCP\AppFramework\{ApiController, Http, Http\DataResponse, Http\RedirectResponse};
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
        $withIndexPHP = str_contains($_SERVER['REQUEST_URI'], "/index.php/");
        return new DataResponse(["authorization" => [
            "strategy" => "oauth2",
            "config" => [
                "host" => URLUtils::getHostURL($this->config),
                "authorization_endpoint" => ($withIndexPHP ? "/index.php/" : "/") . "apps/oauth2/authorize",
                "token_endpoint" => ($withIndexPHP ? "/index.php/" : "/") . "apps/oauth2/api/v1/token",
                "scope" => "",
            ]
        ]]);
    }

    /**
     * @PublicPage
     * @NoCSRFRequired
     * @CORS
     */
    public function resources(): DataResponse
    {
        return new DataResponse(["resources" => [
            "broker" => "webdav",
            "config" => [
                "host" => URLUtils::getHostURL($this->config),
                "endpoint" => "/remote.php/dav/files/{ACCESS_ID}",
                "requires_auth" => true,
            ]
        ]]);
    }
}
