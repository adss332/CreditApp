<?php

declare(strict_types=1);

namespace App\Client\Domain\VO;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
readonly class SSN
{
    public function __construct(
        #[ORM\Column(name: 'ssn')]
        private string $value,
    ) {}

    public function value(): string
    {
        return $this->value;
    }
}
