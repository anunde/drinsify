<?php

namespace App\Api\Checkout\Application\CancelOrder;

final readonly class CancelOrderCommand
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