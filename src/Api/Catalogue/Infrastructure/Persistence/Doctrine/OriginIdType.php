<?php

namespace App\Api\Catalogue\Infrastructure\Persistence\Doctrine;

use App\Api\Catalogue\Domain\Entity\OriginId;
use App\Shared\Infrastructure\UuidType;

final class OriginIdType extends UuidType
{
    const NAME = 'origin_id';
    public function getName(): string
    {
        return self::NAME;
    }

    protected function getValueObjectClassName(): string
    {
        return OriginId::class;
    }
}