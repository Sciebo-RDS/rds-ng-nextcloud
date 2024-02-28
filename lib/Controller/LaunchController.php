<?php

namespace OCA\RdsNg\Controller;

use OCP\IRequest;
use OCP\AppFramework\{Controller, Http\ContentSecurityPolicy, Http\RedirectResponse, Http\TemplateResponse};

use OCA\RdsNg\AppInfo\Application;
use OCA\RdsNg\Service\AppService;
use OCP\IURLGenerator;

class LaunchController extends Controller {
    private AppService $appService;

    private IURLGenerator $urlGenerator;

    public function __construct(IRequest $request, AppService $appService, IURLGenerator $urlGenerator) {
        parent::__construct(Application::APP_ID, $request);

        $this->appService = $appService;

        $this->urlGenerator = $urlGenerator;
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
        $csp->addAllowedScriptDomain($host);
        $csp->addAllowedScriptDomain($appHost);
        $csp->addAllowedScriptDomain("blob:");
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
        return new RedirectResponse($this->appService->settings()->getAppURL());
    }
}
