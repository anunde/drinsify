<?php

namespace App\Api\Checkout\Domain\Entity;

use App\Api\Shared\Domain\Entity\ProductId;
use App\Shared\Domain\Entity;

class OrderLine extends Entity
{
    public function __construct(
        private readonly OrderLineId $id,
        private OrderId $orderId,
        private ProductId $productId,
        private OrderLinePrice $price,
        private OrderLineTaxes $taxes,
        private OrderLineQuantity $quantity
    )
    {
    }

    public static function create(
        $orderId,
        $productId,
        $price,
        $taxes,
        $quantity
    ): self
    {
        return new self(
            new OrderLineId(OrderLineId::random()),
            new OrderId($orderId),
            new ProductId($productId),
            new OrderLinePrice($price),
            new OrderLineTaxes(\json_encode($taxes)),
            new OrderLineQuantity($quantity)
        );
    }

    /**
     * @return OrderLineId
     */
    public function getId(): OrderLineId
    {
        return $this->id;
    }

    /**
     * @return OrderId
     */
    public function getOrderId(): OrderId
    {
        return $this->orderId;
    }

    /**
     * @return ProductId
     */
    public function getProductId(): ProductId
    {
        return $this->productId;
    }

    /**
     * @return OrderLinePrice
     */
    public function getPrice(): OrderLinePrice
    {
        return $this->price;
    }

    /**
     * @return OrderLineTaxes
     */
    public function getTaxes(): OrderLineTaxes
    {
        return $this->taxes;
    }

    /**
     * @return OrderLineQuantity
     */
    public function getQuantity(): OrderLineQuantity
    {
        return $this->quantity;
    }
}