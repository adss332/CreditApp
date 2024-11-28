<?php

declare(strict_types=1);

namespace App\Client\Application\Handler;

use App\Client\Domain\Entity\Client;
use App\Client\Application\Dto\ClientCreditConditionsDto;
use App\Client\Domain\Enum\ClientStatesEnum;
use App\Client\Domain\Repository\ClientRepositoryInterface;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class CheckClientForCreditConditionsHandler
{
    public function __construct(
        private ClientRepositoryInterface $clientRepository,
        private ValidatorInterface $validator,
    ) {}

    public function handle(int $clientId): bool
    {
        $client = $this->clientRepository->findById($clientId);

        if (!$client instanceof Client) {
            throw new EntityNotFoundException('Client not found.');
        }

        $dto = new ClientCreditConditionsDto(
            state: $client->getAddress()->getState(),
            ficoScore: $client->getFicoScore(),
            income: $client->getIncome(),
            age: $client->getAge(),
        );

        $errors = $this->validator->validate($dto);

        if (count($errors) > 0) {
            $errorMessage = '';
            foreach ($errors as $error) {
                $errorMessage .= $error->getPropertyPath() . ': ' . $error->getMessage() . "\n";
            }

            throw new ValidatorException($errorMessage);
        }

        return !($dto->state === ClientStatesEnum::NY->value && random_int(0, 1) === 0);
    }
}
