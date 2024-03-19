<?php

namespace App\Api\Profile\Application\ListUserTokens;

use App\Api\Shared\Infrastructure\Persistence\Repository\TokenRepository;

final readonly class ListUserTokensQueryHandler
{
    public function __construct(
        private TokenRepository $repository
    )
    {
    }

    public function __invoke(ListUserTokensQuery $query): array
    {
        return $this->repository->findByUser($query->getUserId());

    }
}