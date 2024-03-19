<?php

namespace App\Api\Checkout\Application\UserEmptyCart;

final class UserEmptyCartCommand
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