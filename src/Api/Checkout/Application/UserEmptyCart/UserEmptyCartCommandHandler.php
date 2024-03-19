<?php

namespace App\Api\Checkout\Application\UserEmptyCart;

use App\Api\Checkout\Domain\Repository\CartRepositoryInterface;
use App\Api\Shared\Domain\Repository\ProductRepositoryInterface;

final readonly class UserEmptyCartCommandHandler
{
    public function __construct(
        private CartRepositoryInterface $cartRepository,
        private ProductRepositoryInterface $productRepository
    )
    {
    }

    public function __invoke(UserEmptyCartCommand $command): void
    {
        $cart = $this->cartRepository->findOneWithLinesOrFail($command->getUserId());

        foreach ($cart->getLines() as $line) {
            if (null !== $product = $this->productRepository->findOneWriteById($line->getProductId())) {
                $product->addNumberQuantity($line->getQuantity()->value());
                $this->productRepository->save($product);
            }
        }

        $this->cartRepository->clear($cart);
    }
}