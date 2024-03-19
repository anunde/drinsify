<?php

namespace App\Api\Shared\Infrastructure\Persistence\Doctrine;

use App\Api\Shared\Domain\Entity\CellarId;
use App\Shared\Infrastructure\UuidType;

class CellarIdType extends UuidType
{
    const NAME = "cellar_id";
    public function getName(): string
    {
        return self::NAME;
    }

    protected function getValueObjectClassName(): string
    {
        return CellarId::class;
    }
}