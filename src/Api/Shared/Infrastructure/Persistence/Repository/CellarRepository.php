<?php

namespace App\Api\Shared\Infrastructure\Persistence\Repository;

use App\Api\Shared\Domain\Entity\Cellar;
use App\Api\Shared\Domain\Repository\CellarRepositoryInterface;
use App\Api\Shared\Infrastructure\Persistence\DataSource\DoctrineDataSource;
use Doctrine\DBAL\Exception;

class CellarRepository implements CellarRepositoryInterface
{
    public function __construct(
        private readonly DoctrineDataSource $dataSource
    )
    {
    }

    public function save(Cellar $cellar): void
    {
        $this->dataSource->persist($cellar, true);
    }


    /**
     * @throws Exception
     */
    public function findAll(): array
    {
        $sql = "
            SELECT
                c.id,
                c.name,
                c.image
            FROM cellar c
        ";

        $conn = $this->dataSource->entityManager()->getConnection();
        $stmt = $conn->executeQuery($sql);

        return $stmt->fetchAll();
    }
}