<?php

namespace App\Api\Auth\Domain\Entity\User;

use App\Api\Shared\Domain\ValueObject\DateTimeValueObject;

final class UserBirthdate extends DateTimeValueObject
{
    public function __construct(\DateTime $value)
    {
        parent::__construct($value);
        $this->ensureIsValid($value);
    }

    private function ensureIsValid(\DateTime $value): void
    {
        $now = new \DateTime();

        if(18 > $now->diff($value)->y) {
            throw new \InvalidArgumentException('You have to be older than 18 years old to register in the platform');
        }
    }
}