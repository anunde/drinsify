<?php

namespace App\Api\Catalogue\Infrastructure\Persistence\Doctrine;

use App\Api\Catalogue\Domain\Entity\DenominationId;
use App\Shared\Infrastructure\UuidType;

class DenominationIdType extends UuidType
{
    const NAME = "denomination_id";
    public function getName(): string
    {
        return self::NAME;
    }

    protected function getValueObjectClassName(): string
    {
        return DenominationId::class;
    }
}