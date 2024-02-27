<?php

namespace OCA\RdsNg\Controller;

use OCA\RdsNg\AppInfo\Application;
use OCP\IRequest;
use OCP\AppFramework\{
    Controller,
    Http\TemplateResponse,
};

class PageController extends Controller {
    public function __construct(IRequest $request) {
        parent::__construct(Application::APP_ID, $request);
    }

    /*** Page endpoints ***/

    /**
     * @NoCSRFRequired
     * @NoAdminRequired
     */
    public function index() {
        return new TemplateResponse(Application::APP_ID, 'main');
    }
}
