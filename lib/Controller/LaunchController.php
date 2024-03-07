<?php

namespace OCA\RdsNg\Controller;

use OCA\RdsNg\AppInfo\Application;
use OCA\RdsNg\Service\AppService;
use OCA\RdsNg\Service\UserTokenService;
use OCA\RdsNg\Settings\AppSettings;

use OCP\AppFramework\{Controller, Http\ContentSecurityPolicy, Http\RedirectResponse, Http\TemplateResponse};
use OCP\IRequest;
use OCP\IURLGenerator;

class LaunchController extends Controller {
    private IURLGenerator $urlGenerator;

    private AppService $appService;
    private UserTokenService $tokenService;

    private AppSettings $appSettings;

    public function __construct(
        IRequest         $request,
        IURLGenerator    $urlGenerator,
        AppService       $appService,
        UserTokenService $tokenService,
        AppSettings      $appSettings) {
        parent::__construct(Application::APP_ID, $request);

        $this->urlGenerator = $urlGenerator;

        $this->appService = $appService;
        $this->tokenService = $tokenService;

        $this->appSettings = $appSettings;
    }

    /*** Page endpoints ***/

    /**
     * @NoCSRFRequired
     * @NoAdminRequired
     */
    public function launch(): TemplateResponse {
        $host = $_SERVER["HTTP_HOST"];
        $appHost = $this->appService->getAppHost(true);

        $csp = new ContentSecurityPolicy();
        $csp->addAllowedConnectDomain($host);
        $csp->addAllowedConnectDomain($appHost);
        $csp->addAllowedConnectDomain("blob:");
        $csp->addAllowedFrameDomain($host);
        $csp->addAllowedFrameDomain($appHost);
        $csp->addAllowedFrameDomain("blob:");

        $resp = new TemplateResponse(Application::APP_ID, "launcher/launcher", [
            "app-source" => $this->urlGenerator->linkToRoute(Application::APP_ID . ".launch.app"),
            "app-origin" => $appHost,
        ]);
        $resp->setContentSecurityPolicy($csp);
        return $resp;
    }

    /**
     * @NoCSRFRequired
     * @NoAdminRequired
     */
    public function app(): RedirectResponse {
        $jwt = $this->tokenService->generateUserToken()->generateJWT($this->appSettings->getUserTokenKeys());
        return new RedirectResponse($this->appService->settings()->getAppURL() . "?" . http_build_query([
                "user-token" => $jwt
            ]));
    }
}
