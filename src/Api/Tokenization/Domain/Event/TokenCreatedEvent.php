<?php

namespace App\Api\Tokenization\Domain\Event;

use App\Api\Shared\Domain\Event\DomainEvent;

class TokenCreatedEvent extends DomainEvent
{
    public const NAME_EVENT = 'token.created';

    public function __construct(
        protected string $userId,
        protected string $tokenId
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
    public function getTokenId(): string
    {
        return $this->tokenId;
    }

}