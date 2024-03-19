<?php

namespace App\Api\Catalogue\Infrastructure\Persistence\Repository;

use App\Api\Catalogue\Domain\Entity\Like;
use App\Api\Catalogue\Domain\Repository\LikeRepositoryInterface;
use App\Api\Shared\Infrastructure\Persistence\DataSource\InMemoryDataSource;

class LikeRepositoryTest implements LikeRepositoryInterface
{
    private array $likes = [];
    public function save(Like $like): void
    {
        $this->likes[] = $like;
    }

    public function remove(Like $like): void
    {
        $this->likes = [];
    }

    public function findOneByUserIdAndProductId(string $userId, string $productId): ?Like
    {
        $likeData = InMemoryDataSource::$data['Api']['likes'];

        $result = \array_filter($likeData, function ($like) use ($userId, $productId) {
            return $like['user_id'] === $userId && $like['product_id'] === $productId;
        });

        if (!$result) {
            return null;
        }

        return Like::fromPrimitives(current($result));
    }

    public function findByUserId(string $userId): array
    {
        // TODO: Implement findByUserId() method.
    }
}