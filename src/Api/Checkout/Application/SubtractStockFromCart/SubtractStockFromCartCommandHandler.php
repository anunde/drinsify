<?php

namespace App\Api\Checkout\Application\SubtractStockFromCart;

use App\Api\Checkout\Application\UserEmptyCart\UserEmptyCartCommand;
use App\Api\Checkout\Domain\Repository\CartRepositoryInterface;

final readonly class SubtractStockFromCartCommandHandler
{
    public function __construct(
        private CartRepositoryInterface $cartRepository,
    )
    {
    }

    public function __invoke(SubtractStockFromCartCommand $command): void
    {
        $cart = $this->cartRepository->findOneWithLinesOrFail($command->getUserId());
        $this->cartRepository->clear($cart);
    }
}