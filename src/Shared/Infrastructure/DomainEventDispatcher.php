<?php

namespace App\Shared\Infrastructure;

use App\Shared\Domain\DomainEvent;
use App\Shared\Domain\DomainEventListener;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

readonly class DomainEventDispatcher
{
    public function __construct(private EventDispatcherInterface $dispatcher)
    {
    }

    public function dispatch(DomainEvent $domainEvent): void
    {
        $listeners = $this->dispatcher->getListeners(get_class($domainEvent));

        foreach ($listeners as $listener) {
                if($listener instanceof DomainEventListener) {
                    $listener->handle($domainEvent);
                }
        }
    }
}