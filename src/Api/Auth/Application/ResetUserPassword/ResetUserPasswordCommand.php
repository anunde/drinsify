<?php

namespace App\Api\Auth\Application\ResetUserPassword;

final readonly class ResetUserPasswordCommand
{
    public function __construct(
        private string $uid,
        private string $reset_password_token,
        private string $password
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
    public function getResetPasswordToken(): string
    {
        return $this->reset_password_token;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}