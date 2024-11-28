<?php

declare(strict_types=1);

namespace App\Client\infrastructure\Persistence;

use App\Client\Domain\Entity\Client;
use App\Client\Domain\Repository\ClientRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Client>
 *
 * @method null|Client find($id, $lockMode = null, $lockVersion = null)
 * @method null|Client findOneBy(array $criteria, array $orderBy = null)
 * @method Client[] findAll()
 * @method Client[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientRepository extends ServiceEntityRepository implements ClientRepositoryInterface
{
    public function __construct(
        private readonly ManagerRegistry $registry,
    ) {
        parent::__construct($this->registry, Client::class);
    }

    public function findById(int $id): ?Client
    {
        return $this->find($id);
    }

    public function create(Client $client): void
    {
        $this->getEntityManager()->persist($client);
        $this->getEntityManager()->flush();
    }

    public function save(): void
    {
        $this->getEntityManager()->flush();
    }
}
