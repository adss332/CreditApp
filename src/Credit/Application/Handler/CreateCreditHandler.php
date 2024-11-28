<?php

declare(strict_types=1);

namespace App\Credit\Application\Handler;

use App\Client\Domain\Entity\Client;
use App\Client\Domain\Enum\ClientStatesEnum;
use App\Client\Domain\Repository\ClientRepositoryInterface;
use App\Credit\Application\Dto\CreateCreditDto;
use App\Credit\Domain\Entity\Credit;
use App\Credit\Domain\Repository\CreditRepositoryInterface;
use App\Shared\MailSend\Domain\MailSenderInterface;
use DateTimeImmutable;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class CreateCreditHandler
{
    public function __construct(
        private CreditRepositoryInterface $creditRepository,
        private ClientRepositoryInterface $clientRepository,
        private MailSenderInterface $mailSender,
        private ValidatorInterface $validator,
    ) {}

    /** @throws ValidatorException */
    public function handle(CreateCreditDto $createCreditDto): void
    {
        $errors = $this->validator->validate($createCreditDto);

        if (count($errors) > 0) {
            $errorMessage = '';
            foreach ($errors as $error) {
                $errorMessage .= $error->getPropertyPath() . ': ' . $error->getMessage() . "\n";
            }

            throw new ValidatorException($errorMessage);
        }

        $client = $this->clientRepository->findById($createCreditDto->clientId);

        if (!$client instanceof Client) {
            throw new EntityNotFoundException('Client not found');
        }

        if ($this->creditRepository->findByClientId($createCreditDto->clientId) instanceof Credit) {
            throw new ValidatorException('Client already has credit');
        }

        $percentRate = $createCreditDto->percentRate;

        if ($client->getAddress()->getState() === ClientStatesEnum::CA->value) {
            $percentRate = bcadd($percentRate, Credit::CA_PERCENT_RATE, 3);
        }

        $credit = new Credit(
            client: $client,
            productName: $createCreditDto->productName,
            endDate: (new DateTimeImmutable())->setTimestamp($createCreditDto->endDate),
            percentRate: $percentRate,
            creditSum: $createCreditDto->creditSum,
        );

        $this->creditRepository->create($credit);

        $this->mailSender->send($client->getEmail(), 'Credit created', 'Credit created for u.');
    }
}
