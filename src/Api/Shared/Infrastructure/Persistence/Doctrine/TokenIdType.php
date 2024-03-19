<?php

namespace App\Api\Shared\Infrastructure\Persistence\Doctrine;

use App\Api\Shared\Domain\Entity\TokenId;
use App\Shared\Infrastructure\UuidType;

class TokenIdType extends UuidType
{
    const NAME = 'token_id';

    public function getName(): string
    {
        return self::NAME;
    }

    protected function getValueObjectClassName(): string
    {
        return TokenId::class;
    }
}