<?php

namespace App\Api\Checkout\Application\GenerateOrderFromCart;

final readonly class GenerateOrderFromCartCommand
{
    public function __construct(
        private string $userId,
        private string $method,
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
    public function getMethod(): string
    {
        return $this->method;
    }
}