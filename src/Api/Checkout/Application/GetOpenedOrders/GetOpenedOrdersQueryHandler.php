<?php

namespace App\Api\Checkout\Application\GetOpenedOrders;

use App\Api\Shared\Domain\Repository\OrderRepositoryInterface;

final readonly class GetOpenedOrdersQueryHandler
{
    public function __construct(
        private OrderRepositoryInterface $repository
    )
    {
    }

    public function __invoke(): array
    {
        return $this->repository->findOpenedOrders();
    }
}