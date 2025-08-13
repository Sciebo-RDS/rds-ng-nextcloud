<?php

namespace OCA\RdsNg\Controller;

use OCA\RdsNg\AppInfo\Application;
use OCA\RdsNg\Service\AuthorizationService;
use OCA\RdsNg\Settings\AppSettings;
use OCA\RdsNg\Utility\URLUtils;

use OCP\AppFramework\{ApiController, Http, Http\DataResponse, Http\RedirectResponse};
use OCP\IConfig;
use OCP\IRequest;

class ApiV1Controller extends ApiController
{
    private IConfig $config;

    private AppSettings $appSettings;
    private AuthorizationService $authService;

    public function __construct(IRequest $request, IConfig $config, AppSettings $appSettings, AuthorizationService $authService)
    {
        parent::__construct(Application::APP_ID, $request);

        $this->config = $config;

        $this->appSettings = $appSettings;
        $this->authService = $authService;
    }

    /**
     * @PublicPage
     * @NoCSRFRequired
     */
    public function publicKey(): DataResponse
    {
        return new DataResponse(["public-key" => $this->appSettings->getUserTokenPublicKey()]);
    }

    /**
     * @PublicPage
     * @NoCSRFRequired
     */
    public function authorization(): DataResponse
    {
        return new DataResponse(["authorization" => [
            "strategy" => "oauth2",
            "config" => [
                "host" => URLUtils::getHostURL($this->config),
                "authorization_endpoint" => "/apps/oauth2/authorize",
                "token_endpoint" => "/apps/oauth2/api/v1/token",
                "scope" => "",
            ]
        ]]);
    }

    /**
     * @PublicPage
     * @NoCSRFRequired
     */
    public function authorize(string $strategy): RedirectResponse|DataResponse
    {
        if ($strategy == "") {
            return new DataResponse([
                "message" => "Missing authorization strategy",
                "error" => "Missing authorization strategy",
            ], Http::STATUS_BAD_REQUEST);
        }

        try {
            $redirectURL = $this->authService->getIssuerURL($strategy);
            return new RedirectResponse($redirectURL);
        } catch (\Exception $e) {
            return new DataResponse([
                "message" => "Invalid authorization information for strategy {$strategy}",
                "error" => $e->getMessage()
            ], Http::STATUS_BAD_REQUEST);
        }
    }

    /**
     * @PublicPage
     * @NoCSRFRequired
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
