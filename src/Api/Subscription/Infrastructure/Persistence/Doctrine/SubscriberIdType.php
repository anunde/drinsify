<?php

namespace App\Api\Subscription\Infrastructure\Persistence\Doctrine;

use App\Api\Subscription\Domain\Entity\SubscriberId;
use App\Shared\Infrastructure\UuidType;

class SubscriberIdType extends UuidType
{
    const NAME = "subscriber_id";
    public function getName(): string
    {
        return self::NAME;
    }

    protected function getValueObjectClassName(): string
    {
        return SubscriberId::class;
    }
}