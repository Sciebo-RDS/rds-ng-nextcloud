<?php

namespace OCA\RdsNg\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use OCA\RdsNg\Settings\AppSettings;

class CreateUserTokenKeys extends Command {

    private AppSettings $appSettings;

    public function __construct(AppSettings $appSettings) {
        parent::__construct();

        $this->appSettings = $appSettings;
    }


    protected function configure(): void {
        $this
            ->setName('rdsng:create-user-token-keys')
            ->setDescription('Creates a new pair of public and private keys to sign user tokens.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int {
        $this->appSettings->renewUserTokenKeys();;
        $output->writeln("A new key pair has been created.");
        return self::SUCCESS;
    }
}
