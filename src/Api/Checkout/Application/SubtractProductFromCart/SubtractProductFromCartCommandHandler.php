<?php

namespace App\Api\Checkout\Application\SubtractProductFromCart;

use App\Api\Checkout\Domain\Repository\CartRepositoryInterface;
use App\Api\Shared\Domain\Exception\NotFoundException;
use App\Api\Shared\Domain\Repository\ProductRepositoryInterface;

final readonly class SubtractProductFromCartCommandHandler
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private CartRepositoryInterface $cartRepository
    )
    {
    }

    /**
     * @throws NotFoundException
     */
    public function __invoke(SubtractProductFromCartCommand $command): void
    {
        if(null === $product = $this->productRepository->findOneWriteById($command->getProductId())) {
            throw new NotFoundException(\sprintf('Product not found by id: %s', $command->getProductId()));
        }
        $product->addQuantity();

        $this->cartRepository->checkIfLineExistsByProductIdOrFail($command->getProductId());
        $cart = $this->cartRepository->findOneWithLinesOrFail($command->getUserId());
        $cart->subtractProduct($command->getProductId());
        $cart = $this->cartRepository->clearAndPersist($cart);

        if (0 >= \count($cart->getLines())) {
            $this->cartRepository->remove($cart);
        }

        $this->productRepository->save($product);
    }
}