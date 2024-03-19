<?php

namespace App\Api\Checkout\Domain\Entity;

use App\Api\Shared\Domain\ValueObject\StringValueObject;

class OrderMethod extends StringValueObject
{
    private const METHOD_MERCADOPAGO = "mercadopago";
    private const METHOD_METAMASK = "metamask";

    private const VALID_METHODS = [
        self::METHOD_MERCADOPAGO,
        self::METHOD_METAMASK
    ];

    public function __construct(string $value)
    {
        parent::__construct($value);
        $this->ensureIsValid($value);
    }

    public function ensureIsValid(string $value): void
    {
        if (!\in_array($value, self::VALID_METHODS)) {
            throw new \InvalidArgumentException(\sprintf('Data is not expected: %s', $value));
        }
    }
}