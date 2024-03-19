<?php

namespace App\Api\Catalogue\Infrastructure\Persistence\Doctrine;

use App\Api\Catalogue\Domain\Entity\BrandId;
use App\Shared\Infrastructure\UuidType;

class BrandIdType extends UuidType
{
    const NAME = 'brand_id';
    public function getName()
    {
        return self::NAME;
    }

    protected function getValueObjectClassName(): string
    {
        return BrandId::class;
    }
}