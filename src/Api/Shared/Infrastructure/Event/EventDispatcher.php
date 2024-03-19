<?php

namespace App\Api\Shared\Infrastructure\Event;

use App\Api\Shared\Domain\Event\DomainEvent;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface as SymfonyEventDispatcherInterface;
use App\Api\Shared\Domain\Event\EventDispatcherInterface;

class EventDispatcher implements EventDispatcherInterface
{
    public function __construct(protected SymfonyEventDispatcherInterface $symfonyEventDispatcher)
    {
    }

    public function dispatch(DomainEvent $event): void
    {
        $this->symfonyEventDispatcher->dispatch($event);
    }
}