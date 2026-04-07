<?php

namespace OCA\RdsNg\Command;

use OC\Core\Command\Base;

use OCA\RdsNg\Service\ServerService;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DeleteUser extends Base
{
    private ServerService $serverService;

    public function __construct(ServerService $serverService)
    {
        parent::__construct();

        $this->serverService = $serverService;
    }

    protected function configure(): void
    {
        $this->setName('rdsng:user:delete');
        $this->setDescription('Deletes the user with the specified email address and all related data');

        $this->addOption("email", "e", InputOption::VALUE_REQUIRED, "User email address");

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $userEmail = $input->getOption("email");
        if ($userEmail == "") {
            $output->writeln("<error>User email address is required (specified via --email)</error>");
            return -1;
        }

        $output->writeln("Deleting user with email $userEmail...");

        try {
            $this->serverService->deleteUser($userEmail);
            $output->writeln("<info>User successfully deleted.</info>");
        } catch (\Exception $e) {
            $output->writeln("<error>Unable to delete user: {$e->getMessage()}</error>");
            return 1;
        }

        return 0;
    }
}
