<?php

namespace App\Api\Checkout\Infrastructure\Persistence\Doctrine;

use App\Api\Checkout\Domain\Entity\CartId;
use App\Shared\Infrastructure\UuidType;

class CartIdType extends UuidType
{
    const NAME = "cart_id";
    public function getName(): string
    {
        return self::NAME;
    }

    protected function getValueObjectClassName(): string
    {
        return CartId::class;
    }
}