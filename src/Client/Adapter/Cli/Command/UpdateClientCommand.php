<?php

declare(strict_types=1);

namespace App\Client\Adapter\Cli\Command;

use App\Client\Application\Dto\UpdateClientDto;
use App\Client\Application\Handler\UpdateClientHandler;
use Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:update-client',
    description: 'Update a client',
)]
class UpdateClientCommand extends Command
{
    public function __construct(
        private readonly UpdateClientHandler $updateClientHandler,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Update a client')
            ->addArgument('clientId', InputArgument::REQUIRED, 'Client ID')
            ->addArgument('lastName', InputArgument::REQUIRED, 'Last name')
            ->addArgument('firstName', InputArgument::REQUIRED, 'First name')
            ->addArgument('age', InputArgument::REQUIRED, 'Age')
            ->addArgument('ssn', InputArgument::REQUIRED, 'SSN')
            ->addArgument('address', InputArgument::REQUIRED, 'Address')
            ->addArgument('city', InputArgument::REQUIRED, 'City')
            ->addArgument('state', InputArgument::REQUIRED, 'State')
            ->addArgument('zip', InputArgument::REQUIRED, 'ZIP code')
            ->addArgument('ficoScore', InputArgument::REQUIRED, 'Credit rate FICO')
            ->addArgument('income', InputArgument::REQUIRED, 'Income')
            ->addArgument('email', InputArgument::REQUIRED, 'Email')
            ->addArgument('phoneNumber', InputArgument::REQUIRED, 'Phone number')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $clientId = is_numeric($input->getArgument('clientId')) ? (int) $input->getArgument('clientId') : 0;

        /** @var string $lastName */
        $lastName = $input->getArgument('lastName');

        /** @var string $firstName */
        $firstName = $input->getArgument('firstName');
        $age = is_numeric($input->getArgument('age')) ? (int) $input->getArgument('age') : 0;

        /** @var string $ssn */
        $ssn = $input->getArgument('ssn');

        /** @var string $address */
        $address = $input->getArgument('address');

        /** @var string $city */
        $city = $input->getArgument('city');

        /** @var string $state */
        $state = $input->getArgument('state');

        /** @var string $zip */
        $zip = $input->getArgument('zip');
        $ficoScore = is_numeric($input->getArgument('ficoScore')) ? (int) $input->getArgument('ficoScore') : 0;
        $income = is_numeric($input->getArgument('income')) ? (int) $input->getArgument('income') : 0;

        /** @var string $email */
        $email = $input->getArgument('email');

        /** @var string $phoneNumber */
        $phoneNumber = $input->getArgument('phoneNumber');

        $dto = new UpdateClientDto(
            clientId: $clientId,
            lastName: $lastName,
            firstName: $firstName,
            age: $age,
            ssn: $ssn,
            address: $address,
            city: $city,
            state: $state,
            zip: $zip,
            ficoScore: $ficoScore,
            income: $income,
            email: $email,
            phoneNumber: $phoneNumber,
        );

        try {
            $this->updateClientHandler->handle($dto);
            $output->writeln('<info>Client updated.</info>');

            return Command::SUCCESS;
        } catch (Exception $exception) {
            $output->writeln('<error>Error on client update procedure: ' . $exception->getMessage() . '</error>');

            return Command::FAILURE;
        }
    }
}
