<?php

namespace App\Api\Checkout\Infrastructure\Persistence\Doctrine;

use App\Api\Checkout\Domain\Entity\OrderId;
use App\Shared\Infrastructure\UuidType;

class OrderIdType extends UuidType
{
    private const NAME = "order_id";

    public function getName(): string
    {
        return self::NAME;
    }

    protected function getValueObjectClassName(): string
    {
        return OrderId::class;
    }
}