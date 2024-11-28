<?php

declare(strict_types=1);

namespace App\Credit\Application\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class CreateCreditDto
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Positive]
        public int $clientId,

        #[Assert\NotBlank]
        #[Assert\Length(min: 3, max: 255)]
        public string $productName,

        #[Assert\NotBlank]
        #[Assert\Positive]
        public int $endDate,

        #[Assert\NotBlank]
        public string $percentRate,

        #[Assert\NotBlank]
        #[Assert\GreaterThan(50)]
        public int $creditSum,
    ) {}
}
