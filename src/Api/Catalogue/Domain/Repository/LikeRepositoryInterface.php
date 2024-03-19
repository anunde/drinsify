<?php

namespace App\Api\Catalogue\Domain\Repository;

use App\Api\Catalogue\Domain\Entity\Like;

interface LikeRepositoryInterface
{
    public function save(Like $like): void;

    public function remove(Like $like): void;

    public function findOneByUserIdAndProductId(string $userId, string $productId): ?Like;

    public function findByUserId(string $userId): array;
}