<?php

declare(strict_types=1);

namespace App\Client\Domain\Entity;

use App\Client\Domain\VO\Address;
use App\Client\Domain\VO\SSN;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'client')]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    public function __construct(
        #[ORM\Column]
        private string $lastName,

        #[ORM\Column]
        private string $firstName,

        #[ORM\Column]
        private int $age,

        #[ORM\Embedded(class: SSN::class, columnPrefix: false)]
        private SSN $ssn,

        #[ORM\Embedded(class: Address::class, columnPrefix: false)]
        private Address $address,

        #[ORM\Column(name: 'fico_score', type: 'integer')]
        private int $ficoScore,

        #[ORM\Column(type: 'integer')]
        private int $income,

        #[ORM\Column(type: 'string')]
        private string $email,

        #[ORM\Column(name: 'phone_number', type: 'string')]
        private string $phoneNumber,
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getSsn(): SSN
    {
        return $this->ssn;
    }

    public function setSsn(SSN $ssn): self
    {
        $this->ssn = $ssn;

        return $this;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function setAddress(Address $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getFicoScore(): int
    {
        return $this->ficoScore;
    }

    public function setFicoScore(int $ficoScore): self
    {
        $this->ficoScore = $ficoScore;

        return $this;
    }

    public function getIncome(): int
    {
        return $this->income;
    }

    public function setIncome(int $income): self
    {
        $this->income = $income;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }
}
