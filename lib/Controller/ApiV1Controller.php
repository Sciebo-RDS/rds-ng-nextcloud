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
     * @CORS
     */
    public function authorize(): RedirectResponse|DataResponse
    {
        try {
            $payload = base64_decode($_GET["state"]); // TODO: Flexibler
            $payloadJson = json_decode($payload, true, 512, JSON_THROW_ON_ERROR);
            $isserUrl = parse_url($payloadJson["auth_issuer_url"]);

            $scheme = $isserUrl["scheme"];
            $host = $isserUrl["host"];
            $port = $isserUrl["port"] != "" ? ":{$isserUrl['port']}" : "";
            $path = ltrim($isserUrl["path"], "/");
            $query = $_SERVER["QUERY_STRING"];

            // TODO: Whitelist mit erlaubten Issuer URLs (eigener Host geht immer)

            return new RedirectResponse("$scheme://$host$port/$path?$query"); // TODO: Util Funk
        } catch (\Exception $e) {
            return new DataResponse([
                "message" => "Invalid authorization payload",
                "error" => $e->getMessage()
            ], Http::STATUS_BAD_REQUEST);
        }
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
