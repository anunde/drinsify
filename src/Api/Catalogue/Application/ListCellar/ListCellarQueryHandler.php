<?php

namespace App\Api\Catalogue\Application\ListCellar;

use App\Api\Shared\Domain\Repository\CellarRepositoryInterface;

final readonly class ListCellarQueryHandler
{
    public function __construct(
        private CellarRepositoryInterface $repository
    )
    {
    }

    public function __invoke(): array
    {
        return $this->repository->findAll();
    }
}