<?php

declare(strict_types=1);

namespace App\Credit\infrastructure\Persistence;

use App\Credit\Domain\Entity\Credit;
use App\Credit\Domain\Repository\CreditRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Credit>
 *
 * @method null|Credit find($id, $lockMode = null, $lockVersion = null)
 * @method null|Credit findOneBy(array $criteria, array $orderBy = null)
 * @method Credit[] findAll()
 * @method Credit[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CreditRepository extends ServiceEntityRepository implements CreditRepositoryInterface
{
    public function __construct(
        private readonly ManagerRegistry $registry,
    ) {
        parent::__construct($this->registry, Credit::class);
    }

    public function create(Credit $credit): void
    {
        $this->getEntityManager()->persist($credit);
        $this->getEntityManager()->flush();
    }

    public function findByClientId(int $clientId): ?Credit
    {
        return $this->findOneBy(['client' => $clientId]);
    }
}
