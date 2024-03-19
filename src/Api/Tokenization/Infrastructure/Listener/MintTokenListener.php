<?php

namespace App\Api\Tokenization\Infrastructure\Listener;

use App\Api\Tokenization\Application\MintToken\MintTokenCommand;
use App\Api\Tokenization\Application\MintToken\MintTokenCommandHandler;
use App\Api\Tokenization\Domain\Event\TokenCreatedEvent;
use Psr\Log\LoggerInterface;

final readonly class MintTokenListener
{
    public function __construct(
        private MintTokenCommandHandler $handler,
        private LoggerInterface $logger
    )
    {
    }

    public function onTokenCreated(TokenCreatedEvent $event): void
    {
        try {
            $this->handler->__invoke(
                new MintTokenCommand($event->getUserId(), $event->getTokenId())
            );
        } catch (\Throwable $th) {
            $this->logger->error('Error minting the token', [
                'code' => $th->getCode(),
                'message' => $th->getMessage()
            ]);
        }
    }
}