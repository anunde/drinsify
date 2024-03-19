<?php

namespace App\Api\Auth\Application\ActivateUser;

final readonly class ActivateUserCommand
{
    public function __construct(
        private string $uid,
        private string $token
    )
    {
    }

    /**
     * @return string
     */
    public function getUid(): string
    {
        return $this->uid;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }
}