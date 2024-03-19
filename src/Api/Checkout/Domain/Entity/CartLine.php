<?php

namespace App\Api\Checkout\Domain\Entity;

use App\Api\Shared\Domain\Entity\ProductId;
use App\Shared\Domain\Entity;

class CartLine extends Entity
{
    public function __construct(
        private CartLineId $id,
        private CartId $cartId,
        private ProductId $productId,
        private CartLineQuantity $quantity
    )
    {
    }

    public static function create(
        $cartId,
        $productId
    ): self
    {
        return new self(
            new CartLineId(CartLineId::random()),
            new CartId($cartId),
            new ProductId($productId),
            new CartLineQuantity(1)
        );
    }

    /**
     * @return CartLineId
     */
    public function getId(): CartLineId
    {
        return $this->id;
    }

    /**
     * @return ProductId
     */
    public function getProductId(): ProductId
    {
        return $this->productId;
    }

    /**
     * @return CartLineQuantity
     */
    public function getQuantity(): CartLineQuantity
    {
        return $this->quantity;
    }

    public function increaseQuantity(): void
    {
        $this->quantity = new CartLineQuantity($this->getQuantity()->value() + 1);
    }

    public function decreaseQuantity(): void
    {
        $this->quantity = new CartLineQuantity($this->getQuantity()->value() - 1);
    }
}