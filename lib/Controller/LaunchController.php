<?php

namespace OCA\RdsNg\Controller;

use OCA\RdsNg\AppInfo\Application;
use OCA\RdsNg\Service\AppService;
use OCA\RdsNg\Service\UserTokenService;
use OCA\RdsNg\Settings\AppSettings;

use OCP\AppFramework\{Controller, Http\ContentSecurityPolicy, Http\RedirectResponse, Http\TemplateResponse};
use OCA\RdsNg\Utility\URLUtils;
use OCP\IConfig;
use OCP\IRequest;
use OCP\IURLGenerator;

class LaunchController extends Controller
{
    private IURLGenerator $urlGenerator;
    private IConfig $config;

    private AppService $appService;
    private UserTokenService $tokenService;

    private AppSettings $appSettings;

    public function __construct(
        IRequest         $request,
        IURLGenerator    $urlGenerator,
        IConfig          $config,
        AppService       $appService,
        UserTokenService $tokenService,
        AppSettings      $appSettings)
    {
        parent::__construct(Application::APP_ID, $request);

        $this->urlGenerator = $urlGenerator;
        $this->config = $config;

        $this->appService = $appService;
        $this->tokenService = $tokenService;

        $this->appSettings = $appSettings;
    }

    /*** Page endpoints ***/

    /**
     * @NoCSRFRequired
     * @NoAdminRequired
     */
    public function launch(): TemplateResponse
    {
        $host = $_SERVER["HTTP_HOST"];
        $overwriteHost = URLUtils::getHostURL($this->config);
        $appHost = $this->appService->getAppHost(true);

        $csp = new ContentSecurityPolicy();
        $csp->addAllowedConnectDomain($host);
        $csp->addAllowedConnectDomain($appHost);
        $csp->addAllowedConnectDomain("blob:");
        $csp->addAllowedFrameDomain($host);
        $csp->addAllowedFrameDomain($appHost);
        $csp->addAllowedFrameDomain("blob:");
        $csp->addAllowedFrameAncestorDomain($host);
        $csp->addAllowedFrameAncestorDomain($appHost);
        $csp->addAllowedFrameAncestorDomain("blob:");

        if ($host != $overwriteHost) {
            $csp->addAllowedConnectDomain($overwriteHost);
            $csp->addAllowedFrameDomain($overwriteHost);
            $csp->addAllowedFrameAncestorDomain($overwriteHost);
        }

        $resp = new TemplateResponse(Application::APP_ID, "launcher/launcher", [
            "app-source" => $this->urlGenerator->linkToRoute(Application::APP_ID . ".launch.app") . "?" . $_SERVER["QUERY_STRING"],
            "app-origin" => $appHost,
        ]);
        $resp->setContentSecurityPolicy($csp);
        return $resp;
    }

    /**
     * @NoCSRFRequired
     * @NoAdminRequired
     */
    public function app(): RedirectResponse
    {
        $jwt = $this->tokenService->generateUserToken()->generateJWT($this->appSettings->getUserTokenKeys());
        $queryParams = [
            "instance-id" => $this->appSettings->getInstanceId(),
            "user-token" => $jwt,
        ];
        $this->getOAuth2QueryParams($queryParams);
        return new RedirectResponse($this->appService->settings()->getAppURL() . "?" . http_build_query($queryParams));
    }

    private function getOAuth2QueryParams(array &$queryParams): void
    {
        if (array_key_exists("state", $_GET) && array_key_exists("code", $_GET)) {
            $queryParams["auth:action"] = "request";
            $queryParams["auth:code"] = $_GET["code"];
            $queryParams["auth:payload"] = $_GET["state"];
        }
    }
}
