<?php

namespace App\Api\Shared\Domain\Repository;

use App\Api\Checkout\Domain\Entity\Order;

interface OrderRepositoryInterface
{
    public function save(Order $order): void;

    public function checkIfNotExistsActivatedOrder(string $userId): void;

    public function findOneByUserId(string $userId): ?Order;

    public function findOneByInternalReferenceOrFail(string $internalReference): Order;

    public function findOnePaidByUserIdAndInternalReference(string $userId, string $internalReference): Order;

    public function findOpenedOrders(): array;
}