<?php

namespace App\Api\Checkout\Application\ExpireCart;

use App\Api\Checkout\Domain\Repository\CartRepositoryInterface;
use App\Api\Shared\Domain\Repository\ProductRepositoryInterface;

final readonly class ExpireCartCommandHandler
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private CartRepositoryInterface $cartRepository
    )
    {
    }

    public function __invoke(): void
    {
        if(!empty($carts = $this->cartRepository->findAllHaveToExpire())) {
            foreach ($carts as $cart) {
                foreach ($cart->getLines() as $line) {
                    if (null !== $product = $this->productRepository->findOneWriteById($line->getProductId())) {
                        $product->addNumberQuantity($line->getQuantity()->value());
                        $this->productRepository->save($product);
                    }
                }

                $this->cartRepository->clear($cart);
            }
        }
    }
}