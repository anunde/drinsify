<?php

namespace App\Api\Shared\Domain\Event;

interface EventDispatcherInterface
{
    public function dispatch(DomainEvent $event);
}