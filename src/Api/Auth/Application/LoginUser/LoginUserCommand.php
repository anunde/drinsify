<?php

namespace App\Api\Auth\Application\LoginUser;

readonly class LoginUserCommand
{
    public function __construct(
        private string $email,
        private string $password
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

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }


}