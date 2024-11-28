<?php

declare(strict_types=1);

namespace App\Client\Application\Handler;

use App\Client\Application\Dto\CreateClientDto;
use App\Client\Domain\Entity\Client;
use App\Client\Domain\Repository\ClientRepositoryInterface;
use App\Client\Domain\VO\Address;
use App\Client\Domain\VO\SSN;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class CreateClientHandler
{
    public function __construct(
        private ClientRepositoryInterface $clientRepository,
        private ValidatorInterface $validator,
    ) {}

    /** @throws ValidatorException */
    public function handle(CreateClientDto $createClientDto): void
    {
        $errors = $this->validator->validate($createClientDto);

        if (count($errors) > 0) {
            $errorMessage = '';
            foreach ($errors as $error) {
                $errorMessage .= $error->getPropertyPath() . ': ' . $error->getMessage() . "\n";
            }

            throw new ValidatorException($errorMessage);
        }

        $ssn = new SSN($createClientDto->ssn);
        $address = new Address(
            address: $createClientDto->address,
            city: $createClientDto->city,
            state: $createClientDto->state,
            zip: $createClientDto->zip,
        );

        $client = new Client(
            lastName: $createClientDto->lastName,
            firstName: $createClientDto->firstName,
            age: $createClientDto->age,
            ssn: $ssn,
            address: $address,
            ficoScore: $createClientDto->ficoScore,
            income: $createClientDto->income,
            email: $createClientDto->email,
            phoneNumber: $createClientDto->phoneNumber,
        );

        $this->clientRepository->create($client);
    }
}
