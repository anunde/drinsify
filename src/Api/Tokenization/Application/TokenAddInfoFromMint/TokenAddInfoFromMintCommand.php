<?php

namespace App\Api\Tokenization\Application\TokenAddInfoFromMint;

final readonly class TokenAddInfoFromMintCommand
{
    public function __construct(
        private string $tokenId,
        private string $tokenNumber
    )
    {
    }

    /**
     * @return string
     */
    public function getTokenId(): string
    {
        return $this->tokenId;
    }

    /**
     * @return string
     */
    public function getTokenNumber(): string
    {
        return $this->tokenNumber;
    }
}