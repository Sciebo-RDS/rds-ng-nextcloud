<?php

namespace OCA\RdsNg\Command;

use OC\Core\Command\Base;

use OCA\RdsNg\Service\CommandService;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DeleteUser extends Base
{
    private CommandService $serverService;

    public function __construct(CommandService $serverService)
    {
        parent::__construct();

        $this->serverService = $serverService;
    }

    protected function configure(): void
    {
        $this->setName('rdsng:user:delete');
        $this->setDescription('Deletes the user with the specified ID and all related data');

        $this->addOption("user-id", null, InputOption::VALUE_REQUIRED, "The user ID");

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $userID = $input->getOption("user-id");
        if ($userID == "") {
            $output->writeln("<error>User ID is required (specified via --user-id)</error>");
            return -1;
        }

        $output->writeln("Deleting user with ID {$userID}...");

        try {
            $this->serverService->deleteUser($userID);
            $output->writeln("<info>User successfully deleted.</info>");
        } catch (\Exception $e) {
            $output->writeln("<error>Unable to delete user: {$e->getMessage()}</error>");
            return 1;
        }

        return 0;
    }
}
