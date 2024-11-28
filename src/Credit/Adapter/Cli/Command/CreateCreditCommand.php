<?php

declare(strict_types=1);

namespace App\Credit\Adapter\Cli\Command;

use App\Client\Application\Handler\CheckClientForCreditConditionsHandler;
use App\Credit\Application\Dto\CreateCreditDto;
use App\Credit\Application\Handler\CreateCreditHandler;
use Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:create-credit',
    description: 'Create credit for a client',
)]
class CreateCreditCommand extends Command
{
    public function __construct(
        private readonly CheckClientForCreditConditionsHandler $checkClientForCreditConditionsHandler,
        private readonly CreateCreditHandler $createCreditHandler,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Check a client for credit conditions')
            ->addArgument('clientId', InputArgument::REQUIRED, 'Client ID')
            ->addArgument('productName', InputArgument::REQUIRED, 'Product name')
            ->addArgument('endDate', InputArgument::REQUIRED, 'End date (timestamp)')
            ->addArgument('percentRate', InputArgument::REQUIRED, 'Percent rate')
            ->addArgument('creditSum', InputArgument::REQUIRED, 'Credit sum')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $clientId = is_numeric($input->getArgument('clientId')) ? (int) $input->getArgument('clientId') : 0;

        /** @var string $productName */
        $productName = $input->getArgument('productName');
        $endDate = is_numeric($input->getArgument('endDate')) ? (int) $input->getArgument('endDate') : 0;

        /** @var string $percentRate */
        $percentRate = $input->getArgument('percentRate');
        $creditSum = is_numeric($input->getArgument('creditSum')) ? (int) $input->getArgument('creditSum') : 0;

        try {
            $response = $this->checkClientForCreditConditionsHandler->handle($clientId);

            if ($response) {
                $createCreditDto = new CreateCreditDto(
                    clientId: $clientId,
                    productName: $productName,
                    endDate: $endDate,
                    percentRate: $percentRate,
                    creditSum: $creditSum,
                );

                $this->createCreditHandler->handle($createCreditDto);

                $output->writeln('<info>Credit created</info>');

                return Command::SUCCESS;
            }

            $output->writeln('<info>Credit was not created.</info>');

            return Command::SUCCESS;
        } catch (Exception $exception) {
            $output->writeln('<error>Error on credit creation: ' . $exception->getMessage() . '</error>');

            return Command::FAILURE;
        }
    }
}
