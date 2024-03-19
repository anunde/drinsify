<?php

namespace App\Api\Catalogue\Application\DetailToken;

use App\Api\Catalogue\Domain\Read\TokenDetailDTO;
use App\Api\Shared\Domain\Repository\TokenRepositoryInterface;

final readonly class DetailTokenQueryHandler
{
    public function __construct(
        private TokenRepositoryInterface $repository
    )
    {
    }

    public function __invoke(DetailTokenQuery $query): ?TokenDetailDTO
    {
        return $this->repository->findReadById($query->getId());
    }
}