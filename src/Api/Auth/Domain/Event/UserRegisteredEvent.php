<?php

namespace App\Api\Auth\Domain\Event;

use App\Api\Shared\Domain\Event\DomainEvent;


class UserRegisteredEvent extends DomainEvent
{
    public const NAME_EVENT = "user.registered";

    public function __construct(
        protected string $userId,
        protected string $userEmail,
        protected string $userName,
        protected string $token,
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
    public function getToken(): string
    {
        return $this->token;
    }
}