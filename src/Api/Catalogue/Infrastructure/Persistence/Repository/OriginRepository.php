<?php

namespace App\Api\Catalogue\Infrastructure\Persistence\Repository;

use App\Api\Catalogue\Domain\Repository\OriginRepositoryInterface;
use App\Api\Shared\Infrastructure\Persistence\DataSource\DoctrineDataSource;
use Doctrine\DBAL\Exception;

class OriginRepository implements OriginRepositoryInterface
{
    public function __construct(
        private readonly DoctrineDataSource $dataSource
    )
    {
    }

    /**
     * @throws Exception
     */
    public function findAll(): array
    {
        $sql = "
            SELECT
                o.id,
                o.name
            FROM origin o
        ";

        $conn = $this->dataSource->entityManager()->getConnection();
        $stmt = $conn->executeQuery($sql);

        return $stmt->fetchAll();
    }
}