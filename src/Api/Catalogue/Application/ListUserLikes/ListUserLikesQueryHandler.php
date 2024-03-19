<?php

namespace App\Api\Catalogue\Application\ListUserLikes;

use App\Api\Catalogue\Domain\Repository\LikeRepositoryInterface;

final readonly class ListUserLikesQueryHandler
{
    public function __construct(
        private LikeRepositoryInterface $repository
    )
    {
    }

    public function __invoke(ListUserLikesQuery $query)
    {
        return $this->repository->findByUserId($query->getUserId());
    }
}