<?php

namespace App\Api\Tokenization\Application\TokenizeFromOrder;

use App\Api\Shared\Domain\Entity\Token;
use App\Api\Shared\Domain\Event\EventDispatcherInterface;
use App\Api\Shared\Domain\Repository\OrderRepositoryInterface;
use App\Api\Shared\Domain\Repository\ProductRepositoryInterface;
use App\Api\Shared\Domain\Repository\TokenRepositoryInterface;
use App\Api\Tokenization\Domain\Event\TokenCreatedEvent;

final readonly class TokenizeFromOrderCommandHandler
{
    public function __construct(
        private OrderRepositoryInterface $orderRepository,
        private ProductRepositoryInterface $productRepository,
        private TokenRepositoryInterface $repository,
        private EventDispatcherInterface $dispatcher
    )
    {
    }

    public function __invoke(TokenizeFromOrderCommand $command): void
    {
        $order = $this->orderRepository->findOnePaidByUserIdAndInternalReference($command->getUserId(), $command->getInternalReference());

        foreach ($order->getLines() as $line) {
            $product = $this->productRepository->findOneWriteById($line->getProductId());
            $token = Token::create($command->getUserId(), $product);
            $this->repository->save($token);

            $this->dispatcher->dispatch(
                new TokenCreatedEvent(
                    $command->getUserId(),
                    $token->getId()
                )
            );
        }

        $order->setTokenized();
        $this->orderRepository->save($order);
    }
}