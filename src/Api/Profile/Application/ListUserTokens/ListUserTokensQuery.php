<?php

namespace App\Api\Profile\Application\ListUserTokens;

final readonly class ListUserTokensQuery
{
    public function __construct(
        private string $userId
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
}