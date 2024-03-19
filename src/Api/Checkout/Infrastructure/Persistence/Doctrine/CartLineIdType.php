<?php

namespace App\Api\Checkout\Infrastructure\Persistence\Doctrine;

use App\Api\Checkout\Domain\Entity\CartLineId;
use App\Shared\Infrastructure\UuidType;

class CartLineIdType extends UuidType
{
    const NAME = "cart_line_id";
    public function getName(): string
    {
        return self::NAME;
    }

    protected function getValueObjectClassName(): string
    {
        return CartLineId::class;
    }
}