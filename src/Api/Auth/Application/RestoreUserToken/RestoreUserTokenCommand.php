<?php

namespace App\Api\Auth\Application\RestoreUserToken;

final readonly class RestoreUserTokenCommand
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