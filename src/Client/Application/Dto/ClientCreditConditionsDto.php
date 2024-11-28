<?php

declare(strict_types=1);

namespace App\Client\Application\Dto;

use App\Client\Domain\Enum\ClientStatesEnum;
use Symfony\Component\Validator\Constraints as Assert;

class ClientCreditConditionsDto
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Choice(
            callback: [ClientStatesEnum::class, 'allowedToGetCreditForClient'],
            message: 'State must be allowed.',
        )]
        public string $state,

        #[Assert\NotBlank]
        #[Assert\Positive]
        #[Assert\GreaterThanOrEqual(
            value: 500,
            message: 'FICO score must be at least {{ value }}.',
        )]
        public int $ficoScore,

        #[Assert\NotBlank]
        #[Assert\Positive]
        #[Assert\GreaterThanOrEqual(
            value: 1000,
            message: 'Income must be at least {{ value }}.',
        )]
        public int $income,

        #[Assert\NotBlank]
        #[Assert\Positive]
        #[Assert\GreaterThanOrEqual(
            value: 18,
            message: 'Age must be at least {{ value }}.',
        )]
        public int $age,
    ) {}
}
