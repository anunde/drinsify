<?php

namespace App\Api\Checkout\Application\CheckOrderStatus;

use App\Api\Shared\Domain\Exception\NotFoundException;
use App\Api\Shared\Domain\Repository\OrderRepositoryInterface;

final readonly class CheckOrderStatusQueryHandler
{
    public function __construct(
        private OrderRepositoryInterface $repository
    )
    {
    }

    public function __invoke(CheckOrderStatusQuery $query): string
    {
        if( null !== $this->repository->findOnePaidByUserIdAndInternalReference($query->getUserId(), $query->getInternalReference())) {
            return "success";
        }

        return "pending";
    }
}