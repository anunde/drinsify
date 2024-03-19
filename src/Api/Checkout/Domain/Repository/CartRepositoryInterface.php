<?php

namespace App\Api\Checkout\Domain\Repository;

use App\Api\Checkout\Domain\Entity\Cart;

interface CartRepositoryInterface
{
    public function save(Cart $cart): void;

    public function clearAndPersist(Cart $cart): Cart;

    public function remove(Cart $cart): void;

    public function clear(Cart $cart): void;

    public function findOneByUserId(string $userId): ?Cart;

    public function checkIfLineExistsByProductIdOrFail(string $productId): void;

    public function findOneWithLinesOrFail(string $userId): Cart;

    public function findOneWithLinesAndProductInfoOrFail(string $userId): Cart;

    public function findOneWithProductsArray(string $userId): array;

    public function findAllHaveToExpire(): array;
}