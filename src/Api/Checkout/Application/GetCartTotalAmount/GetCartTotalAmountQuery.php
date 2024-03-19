<?php

namespace App\Api\Checkout\Application\GetCartTotalAmount;

final readonly class GetCartTotalAmountQuery
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