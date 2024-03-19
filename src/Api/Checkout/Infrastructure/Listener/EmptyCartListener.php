<?php

namespace App\Api\Checkout\Infrastructure\Listener;

use App\Api\Checkout\Application\SubtractStockFromCart\SubtractStockFromCartCommand;
use App\Api\Checkout\Application\SubtractStockFromCart\SubtractStockFromCartCommandHandler;
use App\Api\Checkout\Domain\Event\OrderPaidEvent;
use Psr\Log\LoggerInterface;

final readonly class EmptyCartListener
{
    public function __construct(
        private SubtractStockFromCartCommandHandler $handler,
        private LoggerInterface $logger
    )
    {
    }

    public function onOrderPaid(OrderPaidEvent $event): void
    {
        try {
            $this->handler->__invoke(new SubtractStockFromCartCommand($event->getUserId()));
        } catch (\Throwable $th) {
            $this->logger->error('Error clearing the cart', [
                'code' => $th->getCode(),
                'message' => $th->getMessage()
            ]);
        }
    }
}