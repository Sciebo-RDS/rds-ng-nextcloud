<?php

namespace OCA\RdsNg\Controller;

use OCA\RdsNg\AppInfo\Application;
use OCA\RdsNg\Settings\AppSettings;

use OCP\AppFramework\{Controller};
use OCP\IRequest;

class ApiController extends Controller {
    private AppSettings $appSettings;

    public function __construct(IRequest $request, AppSettings $appSettings) {
        parent::__construct(Application::APP_ID, $request);

        $this->appSettings = $appSettings;
    }

    /**
     * @NoCSRFRequired
     * @NoAdminRequired
     */
    public function publicKey(): array {
        return ["public-key" => $this->appSettings->getUserTokenPublicKey()];
    }
}
