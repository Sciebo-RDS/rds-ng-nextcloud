<?php

namespace OCA\RdsNg\Events;

use OCA\RdsNg\Service\AppService;
use OCA\RdsNg\Service\ServerService;

use OCP\EventDispatcher\Event;
use OCP\EventDispatcher\IEventListener;
use OCP\IUser;
use OCP\User\Events\UserDeletedEvent;

class UserDeletedListener implements IEventListener
{
    private AppService $appService;
    private ServerService $serverService;

    public function __construct(AppService $appService, ServerService $serverService)
    {
        $this->appService = $appService;
        $this->serverService = $serverService;
    }


    public function handle(Event $event): void
    {
        if ($event instanceof UserDeletedEvent) {
            $this->onUserDeleted($event->getUser());
        }
    }

    private function onUserDeleted(IUser $user): void
    {
        $userID = $this->appService->normalizeUserID($user->getUID());

        try {
            $this->serverService->deleteUser($userID);
        } catch (\Exception $e) {
            // Just ignore any errors here
        }
    }
}
