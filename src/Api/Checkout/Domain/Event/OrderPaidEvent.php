<?php

namespace App\Api\Checkout\Domain\Event;

use App\Api\Shared\Domain\Event\DomainEvent;

class OrderPaidEvent extends DomainEvent
{
    public const NAME_EVENT = 'order.paid';

    public function __construct(
        protected string $userId,
        protected string $internalReference
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
    public function getInternalReference(): string
    {
        return $this->internalReference;
    }
}