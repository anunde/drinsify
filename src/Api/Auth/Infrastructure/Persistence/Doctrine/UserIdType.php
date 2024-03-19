<?php

namespace App\Api\Auth\Infrastructure\Persistence\Doctrine;

use App\Api\Shared\Domain\Entity\UserId;
use App\Shared\Infrastructure\UuidType;

final class UserIdType extends UuidType
{
    const NAME = 'user_id';

    protected function getValueObjectClassName(): string
    {
        return UserId::class;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}