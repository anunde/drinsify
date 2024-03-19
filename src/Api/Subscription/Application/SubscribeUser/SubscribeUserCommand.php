<?php

namespace App\Api\Subscription\Application\SubscribeUser;

final class SubscribeUserCommand
{
    public function __construct(
        private string $email
    )
    {
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }
}