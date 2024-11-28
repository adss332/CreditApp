<?php

declare(strict_types=1);

namespace App\Client\Domain\VO;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
readonly class Address
{
    public function __construct(
        #[ORM\Column]
        private string $address,

        #[ORM\Column]
        private string $city,

        #[ORM\Column(length: 2)]
        private string $state,

        #[ORM\Column(length: 5)]
        private string $zip,
    ) {}

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function getZip(): string
    {
        return $this->zip;
    }
}
