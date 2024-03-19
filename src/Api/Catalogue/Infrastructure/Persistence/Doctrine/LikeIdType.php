<?php

namespace App\Api\Catalogue\Infrastructure\Persistence\Doctrine;

use App\Api\Catalogue\Domain\Entity\LikeId;
use App\Shared\Infrastructure\UuidType;

class LikeIdType extends UuidType
{
    const NAME = 'like_id';
    public function getName(): string
    {
        return self::NAME;
    }

    protected function getValueObjectClassName(): string
    {
        return LikeId::class;
    }
}