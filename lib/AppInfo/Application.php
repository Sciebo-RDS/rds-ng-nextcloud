<?php

declare(strict_types=1);
// SPDX-FileCopyrightText: University of Muenster <info@uni-muenster.de>
// SPDX-License-Identifier: AGPL-3.0-or-later

namespace OCA\RdsNg\AppInfo;

use OCA\RdsNg\Service\UserTokenService;
use OCA\RdsNg\Settings\AppSettings;

use OCP\AppFramework\App;
use OCP\AppFramework\Bootstrap\IBootContext;
use OCP\AppFramework\Bootstrap\IBootstrap;
use OCP\AppFramework\Bootstrap\IRegistrationContext;

use Throwable;

class Application extends App implements IBootstrap {
    public const APP_ID = 'rdsng';

    public function __construct() {
        parent::__construct(self::APP_ID);
    }

    public function register(IRegistrationContext $context): void {
    }

    public function boot(IBootContext $context): void {
        $this->generateDefaultUserTokenKeys($context);
    }

    private function generateDefaultUserTokenKeys(IBootContext $context): void {
        try {
            $tokenService = $context->getAppContainer()->get(UserTokenService::class);
            $appSettings = $context->getAppContainer()->get(AppSettings::class);

            if ($appSettings->getUserTokenPublicKey() == "" || $appSettings->getUserTokenPrivateKey() == "") {
                $keys = $tokenService->generateUserTokenKeys();
                $appSettings->setUserTokenKeys($keys);
            }
        } catch (Throwable) {
        }
    }
}
