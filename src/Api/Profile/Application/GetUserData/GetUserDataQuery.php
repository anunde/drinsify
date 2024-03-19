<?php

namespace App\Api\Profile\Application\GetUserData;

final readonly class GetUserDataQuery
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