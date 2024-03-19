<?php

namespace App\Api\Checkout\Application\SubtractProductFromCart;

final readonly class SubtractProductFromCartCommand
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