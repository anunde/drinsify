<?php

namespace App\Api\Catalogue\Application\ListUserLikes;

final readonly class ListUserLikesQuery
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