<?php

namespace App\Api\Profile\Application\PutTokenInSale;

final readonly class PutTokenInSaleCommand
{
    public function __construct(
        private string $userId,
        private string $tokenId,
        private float $price
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
    public function getTokenId(): string
    {
        return $this->tokenId;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }
}