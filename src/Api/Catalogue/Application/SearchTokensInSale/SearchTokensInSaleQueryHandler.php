<?php

namespace App\Api\Catalogue\Application\SearchTokensInSale;

use App\Api\Shared\Domain\Repository\TokenRepositoryInterface;

final readonly class SearchTokensInSaleQueryHandler
{
    public function __construct(
        private TokenRepositoryInterface $repository
    )
    {
    }

    public function __invoke(SearchTokensInSaleQuery $query): array
    {
        return $this->repository->findAllWithFilters(
            $query->getCellarId(),
            $query->getOriginId(),
            $query->getBrandId(),
            $query->getDenominationId(),
            $query->getMinPrice(),
            $query->getMaxPrice(),
            $query->getLimit()
        );
    }
}