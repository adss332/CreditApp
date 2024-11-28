<?php

declare(strict_types=1);

namespace App\Client\Application\Dto;

use App\Client\Domain\Enum\ClientStatesEnum;
use Symfony\Component\Validator\Constraints as Assert;

class UpdateClientDto
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Positive]
        public int $clientId,

        #[Assert\NotBlank]
        public string $lastName,

        #[Assert\NotBlank]
        public string $firstName,

        #[Assert\Range(
            notInRangeMessage: 'Age must be from {{ min }} to {{ max }}.',
            min: 18,
            max: 120,
        )]
        public int $age,

        #[Assert\NotBlank]
        #[Assert\Regex(
            pattern: '/^\d{3}-\d{2}-\d{4}$/',
            message: 'SSN is not correct.',
        )]
        public string $ssn,

        #[Assert\NotBlank]
        public string $address,

        #[Assert\NotBlank]
        public string $city,

        #[Assert\NotBlank]
        #[Assert\Choice(
            callback: [ClientStatesEnum::class, 'values'],
            message: 'State must be a valid US state code.',
        )]
        public string $state,

        #[Assert\NotBlank]
        #[Assert\Regex(
            pattern: '/^\d{5}$/',
            message: 'ZIP code length must be 5 numbers.',
        )]
        public string $zip,

        #[Assert\Range(
            notInRangeMessage: 'FICO must be from {{ min }} to {{ max }}.',
            min: 300,
            max: 850,
        )]
        public int $ficoScore,

        #[Assert\NotBlank]
        #[Assert\Positive]
        public int $income,

        #[Assert\NotBlank]
        #[Assert\Email]
        public string $email,

        #[Assert\NotBlank]
        #[Assert\Regex(
            pattern: '/^\+1\d{10}$/',
            message: 'Phone number is not correct.',
        )]
        public string $phoneNumber,
    ) {}
}
