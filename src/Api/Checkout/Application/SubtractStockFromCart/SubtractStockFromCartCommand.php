<?php

namespace App\Api\Checkout\Application\SubtractStockFromCart;

final readonly class SubtractStockFromCartCommand
{
    public function __construct(
        private string $userId
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
}