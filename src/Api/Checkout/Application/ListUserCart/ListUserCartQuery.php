<?php

namespace App\Api\Checkout\Application\ListUserCart;

final readonly class ListUserCartQuery
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