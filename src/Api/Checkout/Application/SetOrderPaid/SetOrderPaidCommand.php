<?php

namespace App\Api\Checkout\Application\SetOrderPaid;

final readonly class SetOrderPaidCommand
{
    public function __construct(
        private string $internalReference,
        private ?string $externalReference
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
     * @return string|null
     */
    public function getExternalReference(): ?string
    {
        return $this->externalReference;
    }
}