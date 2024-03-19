<?php

namespace App\Api\Profile\Application\CancelTokenSale;

final readonly class CancelTokenSaleCommand
{
    public function __construct(
        private string $userId,
        private string $tokenId
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
}