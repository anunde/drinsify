<?php

namespace App\Api\Catalogue\Application\ToogleLikeProduct;

final readonly class ToggleLikeProductCommand
{
    public function __construct(
        private string $userId,
        private string $productId
    )
    {
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getProductId(): string
    {
        return $this->productId;
    }
}