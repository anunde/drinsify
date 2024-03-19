<?php

namespace App\Api\Auth\Application\ResetUserPasswordRequest;

final readonly class ResetUserPasswordRequestCommand
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