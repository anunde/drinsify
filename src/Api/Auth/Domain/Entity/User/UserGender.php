<?php

namespace App\Api\Auth\Domain\Entity\User;

use App\Api\Shared\Domain\ValueObject\StringValueObject;
use http\Exception\InvalidArgumentException;
use phpDocumentor\Reflection\Types\Self_;

final class UserGender extends StringValueObject
{
    private const GENDER_MALE = 'male';
    private const GENDER_FEMALE = 'female';
    private const GENDER_UNDEFINED = 'undefined';

    private const VALID_GENDERS = [
        self::GENDER_MALE,
        self::GENDER_FEMALE,
        self::GENDER_UNDEFINED
    ];

    public function __construct(string $value)
    {
        parent::__construct($value);
        $this->ensureIsValid($value);
    }

    protected function ensureIsValid(string $value): void
    {
        if (!\in_array($value, self::VALID_GENDERS)) {
            throw new \InvalidArgumentException(\sprintf('Data is not expected: %s', $value));
        }
    }
}