<?php

namespace App\Api\Tokenization\Infrastructure\Listener;

use App\Api\Checkout\Domain\Event\OrderPaidEvent;
use App\Api\Tokenization\Application\TokenizeFromOrder\TokenizeFromOrderCommand;
use App\Api\Tokenization\Application\TokenizeFromOrder\TokenizeFromOrderCommandHandler;
use Psr\Log\LoggerInterface;

final readonly class CreateTokenListener
{
    public function __construct(
        private TokenizeFromOrderCommandHandler $handler,
        private LoggerInterface $logger
    )
    {
    }

    public function onOrderPaid(OrderPaidEvent $event): void
    {
        try {
           $this->handler->__invoke(
                new TokenizeFromOrderCommand(
                    $event->getUserId(),
                    $event->getInternalReference()
                )
           );
        } catch (\Throwable $th) {
            $this->logger->error('Error Tokenizing order', [
                'code' => $th->getCode(),
                'message' => $th->getMessage()
            ]);
        }
    }
}