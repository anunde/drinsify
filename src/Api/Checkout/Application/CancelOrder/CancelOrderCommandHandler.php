<?php

namespace App\Api\Checkout\Application\CancelOrder;

use App\Api\Shared\Domain\Repository\OrderRepositoryInterface;

final readonly class CancelOrderCommandHandler
{
    public function __construct(
        private OrderRepositoryInterface $repository
    )
    {
    }

    public function __invoke(CancelOrderCommand $command): void
    {
        $order = $this->repository->findOneByUserId($command->getUserId());

        if ($order) {
            $order->cancel();
            $this->repository->save($order);
        }
    }
}