<?php

namespace App\Api\Checkout\Application\AddExternalReferenceToOrder;

final readonly class AddExternalReferenceToOrderCommand
{
    public function __construct(
        private string $internalReference,
        private string $externalReference
    )
    {
    }

    /**
     * @return string
     */
    public function getInternalReference(): string
    {
        return $this->internalReference;
    }

    /**
     * @return string
     */
    public function getExternalReference(): string
    {
        return $this->externalReference;
    }
}