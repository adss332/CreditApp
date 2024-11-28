<?php

declare(strict_types=1);

namespace App\Client\Application\Handler;

use App\Client\Domain\Entity\Client;
use App\Client\Application\Dto\UpdateClientDto;
use App\Client\Domain\Repository\ClientRepositoryInterface;
use App\Client\Domain\VO\Address;
use App\Client\Domain\VO\SSN;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class UpdateClientHandler
{
    public function __construct(
        private ClientRepositoryInterface $clientRepository,
        private ValidatorInterface $validator,
    ) {}

    public function handle(UpdateClientDto $updateClientDto): void
    {
        $client = $this->clientRepository->findById($updateClientDto->clientId);

        if (!$client instanceof Client) {
            throw new EntityNotFoundException('Client not found.');
        }

        $errors = $this->validator->validate($updateClientDto);

        if (count($errors) > 0) {
            $errorMessage = '';
            foreach ($errors as $error) {
                $errorMessage .= $error->getPropertyPath() . ': ' . $error->getMessage() . "\n";
            }

            throw new ValidatorException($errorMessage);
        }

        $client->setLastName($updateClientDto->lastName)
            ->setFirstName($updateClientDto->firstName)
            ->setAge($updateClientDto->age)
            ->setSsn(new SSN($updateClientDto->ssn))
            ->setAddress(new Address($updateClientDto->address, $updateClientDto->city, $updateClientDto->state, $updateClientDto->zip))
            ->setFicoScore($updateClientDto->ficoScore)
            ->setIncome($updateClientDto->income)
            ->setEmail($updateClientDto->email)
            ->setPhoneNumber($updateClientDto->phoneNumber)
        ;

        $this->clientRepository->save();
    }
}
