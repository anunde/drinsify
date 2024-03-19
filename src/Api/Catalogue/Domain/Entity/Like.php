<?php

namespace App\Api\Catalogue\Domain\Entity;

use App\Api\Shared\Domain\Entity\ProductId;
use App\Api\Shared\Domain\Entity\UserId;
use App\Shared\Domain\Entity;

final class Like extends Entity
{
    public function __construct(
        private LikeId $id,
        private UserId $userId,
        private ProductId $productId
    )
    {
    }

    public static function create(
        string $userId,
        string $productId
    ): self
    {
        return new self(
            new LikeId(LikeId::random()),
            new UserId($userId),
            new ProductId($productId)
        );
    }

    public static function fromPrimitives(array $data): self
    {
        return new self(
            new LikeId($data['id']),
            new UserId($data['user_id']),
            new ProductId($data['product_id'])
        );
    }

    /**
     * @return LikeId
     */
    public function getId(): LikeId
    {
        return $this->id;
    }

    /**
     * @return UserId
     */
    public function getUserId(): UserId
    {
        return $this->userId;
    }

    /**
     * @return ProductId
     */
    public function getProductId(): ProductId
    {
        return $this->productId;
    }
}