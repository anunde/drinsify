<?php

namespace App\Api\Catalogue\Infrastructure\Persistence\Repository;

use App\Api\Catalogue\Domain\Repository\DenominationRepositoryInterface;
use App\Api\Shared\Infrastructure\Persistence\DataSource\DoctrineDataSource;
use Doctrine\DBAL\Exception;

class DenominationRepository implements DenominationRepositoryInterface
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
                d.id,
                d.name
            FROM denomination d
        ";

        $conn = $this->dataSource->entityManager()->getConnection();
        $stmt = $conn->executeQuery($sql);

        return $stmt->fetchAll();
    }
}