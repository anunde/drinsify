<?php

namespace App\Api\Tokenization\Domain\DataSource;

interface TokenApiDataSource
{
    public function createToken(string $userAddress, string $tokenId): string;

    public function getTokenUri(string $tokenId): string;
}