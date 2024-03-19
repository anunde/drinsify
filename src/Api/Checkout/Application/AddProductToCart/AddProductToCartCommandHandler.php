<?php

namespace App\Api\Checkout\Application\AddProductToCart;

use App\Api\Checkout\Domain\Entity\Cart;
use App\Api\Checkout\Domain\Repository\CartRepositoryInterface;
use App\Api\Shared\Domain\Exception\ConflictException;
use App\Api\Shared\Domain\Exception\NotFoundException;
use App\Api\Shared\Domain\Repository\ProductRepositoryInterface;

final readonly class AddProductToCartCommandHandler
{
    public function __construct(
        private CartRepositoryInterface $cartRepository,
        private ProductRepositoryInterface $productRepository
    )
    {
    }

    /**
     * @throws NotFoundException
     */
    public function __invoke(AddProductToCartCommand $command): void
    {
        if(null === $product = $this->productRepository->findOneWriteById($command->getProductId())) {
            throw new NotFoundException(\sprintf('Product not found by id: %s', $command->getProductId()));
        }

        $product->subtractQuantity();

        if (null === $cart = $this->cartRepository->findOneByUserId($command->getUserId())) {
            $cart = Cart::create($command->getUserId());
        }

        $cart->addProduct($command->getProductId());
        $this->cartRepository->save($cart);
        $this->productRepository->save($product);
    }
}