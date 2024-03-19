<?php

namespace App\Api\Catalogue\Application\ListDenomination;

use App\Api\Catalogue\Domain\Repository\DenominationRepositoryInterface;

final readonly class ListDenominationQueryHandler
{
    public function __construct(
        private DenominationRepositoryInterface $repository
    )
    {
    }

    public function __invoke(): array
    {
        return $this->repository->findAll();
    }
}