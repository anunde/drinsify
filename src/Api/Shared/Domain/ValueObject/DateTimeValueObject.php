<?php

namespace App\Api\Shared\Domain\ValueObject;

abstract class DateTimeValueObject
{
    public function __construct(protected \DateTime $value)
    {
        $this->isValid($value);
        $this->value();
    }

    public function value(): \DateTime
    {
        return $this->value;
    }

    private function isValid(\DateTime $value): void
    {
        if (!($value instanceof \DateTime)) {
            throw new \InvalidArgumentException(\sprintf("It have to ve an instance of DateTime"));
        }
    }
}