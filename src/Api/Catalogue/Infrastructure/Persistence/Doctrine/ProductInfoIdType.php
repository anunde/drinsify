<?php

namespace App\Api\Catalogue\Infrastructure\Persistence\Doctrine;

use App\Api\Catalogue\Domain\Entity\ProductInfoId;
use App\Shared\Infrastructure\UuidType;

class ProductInfoIdType extends UuidType
{
    const NAME = "product_info_id";
    public function getName(): string
    {
        return self::NAME;
    }

    protected function getValueObjectClassName(): string
    {
        return ProductInfoId::class;
    }
}