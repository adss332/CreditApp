<?php

declare(strict_types=1);

namespace App\Credit\Domain\Entity;

use App\Client\Domain\Entity\Client;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'credit')]
class Credit
{
    public const string CA_PERCENT_RATE = '11.49';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    public function __construct(
        #[ORM\OneToOne(targetEntity: Client::class)]
        #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
        private Client $client,

        #[ORM\Column]
        private string $productName,

        #[ORM\Column(type: 'datetime_immutable')]
        private DateTimeImmutable $endDate,

        #[ORM\Column(type: 'decimal', precision: 5, scale: 3)]
        private string $percentRate,

        #[ORM\Column]
        private int $creditSum,
    ) {}

    public function getClient(): Client
    {
        return $this->client;
    }

    public function setClient(Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getProductName(): string
    {
        return $this->productName;
    }

    public function setProductName(string $productName): self
    {
        $this->productName = $productName;

        return $this;
    }

    public function getEndDate(): DateTimeImmutable
    {
        return $this->endDate;
    }

    public function setEndDate(DateTimeImmutable $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getPercentRate(): string
    {
        return $this->percentRate;
    }

    public function setPercentRate(string $percentRate): self
    {
        $this->percentRate = $percentRate;

        return $this;
    }

    public function getCreditSum(): int
    {
        return $this->creditSum;
    }

    public function setCreditSum(int $creditSum): self
    {
        $this->creditSum = $creditSum;

        return $this;
    }
}
