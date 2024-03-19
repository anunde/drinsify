<?php

namespace App\Api\Auth\Domain\Event;

use App\Api\Shared\Domain\Event\DomainEvent;

class UserRequestResetPasswordEvent extends DomainEvent
{
    public const NAME_EVENT = 'user.request_reset_password';

    public function __construct(
        protected string $userId,
        protected string $userName,
        protected string $userEmail,
        protected string $resetPasswordToken,
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
    public function getUserEmail(): string
    {
        return $this->userEmail;
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->userName;
    }

    /**
     * @return string
     */
    public function getResetPasswordToken(): string
    {
        return $this->resetPasswordToken;
    }
}