<?php

namespace App\Api\Catalogue\Application\ListBrand;

use App\Api\Catalogue\Domain\Repository\BrandRepositoryInterface;

final readonly class ListBrandQueryHandler
{
    public function __construct(
        private BrandRepositoryInterface $repository
    )
    {
    }

    public function __invoke(): array
    {
        return $this->repository->findAll();
    }
}