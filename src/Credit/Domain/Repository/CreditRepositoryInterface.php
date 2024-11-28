<?php

declare(strict_types=1);

namespace App\Credit\Domain\Repository;

use App\Credit\Domain\Entity\Credit;

interface CreditRepositoryInterface
{
    public function create(Credit $credit): void;

    public function findByClientId(int $clientId): ?Credit;
}
