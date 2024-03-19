<?php

namespace App\Api\Shared\Infrastructure\Persistence\Doctrine;

use App\Api\Shared\Domain\Entity\ProductId;
use App\Shared\Infrastructure\UuidType;

final class ProductIdType extends UuidType
{

    const NAME = 'product_id';

    protected function getValueObjectClassName(): string
    {
        return ProductId::class;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}