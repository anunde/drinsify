<?php

namespace App\Api\Checkout\Infrastructure\Persistence\Doctrine;

use App\Api\Checkout\Domain\Entity\OrderLineId;
use App\Shared\Infrastructure\UuidType;

class OrderLineIdType extends UuidType
{
    private const NAME = "order_line_id";

    public function getName(): string
    {
        return self::NAME;
    }

    protected function getValueObjectClassName(): string
    {
        return OrderLineId::class;
    }
}