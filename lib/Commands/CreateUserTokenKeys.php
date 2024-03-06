<?php

namespace OCA\RdsNg\Commands;

use OCA\RdsNg\Service\UserTokenService;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use OCA\RdsNg\Settings\AppSettings;

class CreateUserTokenKeys extends Command {
    private UserTokenService $tokenService;

    private AppSettings $appSettings;

    public function __construct(UserTokenService $tokenService, AppSettings $appSettings) {
        parent::__construct();

        $this->tokenService = $tokenService;

        $this->appSettings = $appSettings;
    }


    protected function configure(): void {
        $this
            ->setName("rdsng:create-user-token-keys")
            ->setDescription("Creates a new pair of public and private keys to sign user tokens.");
    }

    protected function execute(InputInterface $input, OutputInterface $output): int {
        $keys = $this->tokenService->generateUserTokenKeys();
        $this->appSettings->setUserTokenKeys($keys);
        $output->writeln("A new key pair has been created.");
        return self::SUCCESS;
    }
}
