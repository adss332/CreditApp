<?php

declare(strict_types=1);

namespace App\Client\Adapter\Cli\Command;

use App\Client\Application\Handler\CheckClientForCreditConditionsHandler;
use Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:check-client',
    description: 'Check a client for credit conditions',
)]
class CheckClientForCreditConditionsCommand extends Command
{
    public function __construct(
        private readonly CheckClientForCreditConditionsHandler $checkClienthForCreditConditionsHandler,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Check a client for credit conditions')
            ->addArgument('clientId', InputArgument::REQUIRED, 'Client ID')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $clientId = is_numeric($input->getArgument('clientId')) ? (int) $input->getArgument('clientId') : 0;

        try {
            $response = $this->checkClienthForCreditConditionsHandler->handle($clientId);
            $output->writeln("<info>{$response}</info>");

            return Command::SUCCESS;
        } catch (Exception $exception) {
            $output->writeln('<error>Error on client creation: ' . $exception->getMessage() . '</error>');

            return Command::FAILURE;
        }
    }
}
