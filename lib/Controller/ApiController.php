<?php

namespace OCA\RdsNg\Controller;

use OCA\RdsNg\AppInfo\Application;
use OCA\RdsNg\Settings\AppSettings;

use OCP\AppFramework\{ApiController as _ApiController, Http\DataResponse};
use OCP\IRequest;

class ApiController extends _ApiController {
    private AppSettings $appSettings;

    public function __construct(IRequest $request, AppSettings $appSettings) {
        parent::__construct(Application::APP_ID, $request);

        $this->appSettings = $appSettings;
    }

    /**
     * @NoCSRFRequired
     * @NoAdminRequired
     * @CORS
     */
    public function publicKey(): DataResponse {
        return new DataResponse(["public-key" => $this->appSettings->getUserTokenPublicKey()]);
    }
}
