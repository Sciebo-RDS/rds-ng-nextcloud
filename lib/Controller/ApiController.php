<?php

namespace OCA\RdsNg\Controller;

use OCA\RdsNg\AppInfo\Application;
use OCA\RdsNg\Service\ResourcesService;
use OCA\RdsNg\Settings\AppSettings;

use OCP\AppFramework\{ApiController as _ApiController, Http\DataResponse};
use OCP\IRequest;

class ApiController extends _ApiController {
    private ResourcesService $resourcesService;

    private AppSettings $appSettings;

    public function __construct(IRequest $request, ResourcesService $resourcesService, AppSettings $appSettings) {
        parent::__construct(Application::APP_ID, $request);

        $this->resourcesService = $resourcesService;

        $this->appSettings = $appSettings;
    }

    /**
     * @PublicPage
     * @NoCSRFRequired
     * @CORS
     */
    public function publicKey(): DataResponse {
        return new DataResponse(["public-key" => $this->appSettings->getUserTokenPublicKey()]);
    }

    /**
     * @PublicPage
     * @NoCSRFRequired
     * @CORS
     */
    public function resources(): DataResponse {
        // TODO: Temporary only
        $uid = $this->request->getParam("uid");
        if ($uid) {
            return new DataResponse(["resources" => json_encode($this->resourcesService->getResourcesList($uid))]);
        }
        return new DataResponse(["resources" => null]);
    }
}
