<?php

namespace App\Api\Catalogue\Infrastructure\Persistence\Repository;

use App\Api\Catalogue\Domain\Repository\BrandRepositoryInterface;
use App\Api\Shared\Infrastructure\Persistence\DataSource\DoctrineDataSource;
use Doctrine\DBAL\Exception;

class BrandRepository implements BrandRepositoryInterface
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
                b.id,
                b.name
            FROM brand b
        ";

        $conn = $this->dataSource->entityManager()->getConnection();
        $stmt = $conn->executeQuery($sql);

        return $stmt->fetchAll();
    }
}