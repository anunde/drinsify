<?php

namespace App\Api\Catalogue\Application\ListOrigin;

use App\Api\Catalogue\Domain\Repository\OriginRepositoryInterface;

final readonly class ListOriginQueryHandler
{
    public function __construct(
        private OriginRepositoryInterface $repository
    )
    {
    }

    public function __invoke(): array
    {
        return $this->repository->findAll();
    }
}