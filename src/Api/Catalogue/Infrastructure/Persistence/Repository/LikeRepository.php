<?php

namespace App\Api\Catalogue\Infrastructure\Persistence\Repository;

use App\Api\Catalogue\Domain\Entity\Like;
use App\Api\Catalogue\Domain\Repository\LikeRepositoryInterface;
use App\Api\Shared\Infrastructure\Persistence\DataSource\DoctrineDataSource;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\NonUniqueResultException;

readonly class LikeRepository implements LikeRepositoryInterface
{
    public function __construct(
        private DoctrineDataSource $doctrineDataSource
    )
    {
    }

    public function save(Like $like): void
    {
        $this->doctrineDataSource->persist($like, true);
    }

    public function remove(Like $like): void
    {
        $this->doctrineDataSource->remove($like, true);
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findOneByUserIdAndProductId(string $userId, string $productId): ?Like
    {
        $queryBuilder = $this->doctrineDataSource->entityManager()->createQueryBuilder();

        $queryBuilder->select('l')
            ->from(Like::class, 'l')
            ->where('l.userId = :userId')
            ->andWhere('l.productId = :productId')
            ->setParameter('userId', $userId)
            ->setParameter('productId', $productId);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    /**
     * @throws Exception
     */
    public function findByUserId(string $userId): array
    {
        $sql = "SELECT
            l.productId
            FROM likes l
            WHERE l.userId = :userId
        ";

        $conn = $this->doctrineDataSource->entityManager()->getConnection();
        $stmt = $conn->executeQuery($sql, ['userId' => $userId]);

        return $stmt->fetchFirstColumn();
    }
}