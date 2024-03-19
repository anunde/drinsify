<?php

namespace App\Api\Tokenization\Application\TokenizeFromOrder;

final readonly class TokenizeFromOrderCommand
{
    public function __construct(
        private string $userId,
        private string $internalReference
    )
    {
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getInternalReference(): string
    {
        return $this->internalReference;
    }
}