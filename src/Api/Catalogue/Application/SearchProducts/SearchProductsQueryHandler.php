<?php

namespace App\Api\Catalogue\Application\SearchProducts;

use App\Api\Shared\Domain\Entity\Product;
use App\Api\Shared\Domain\Repository\ProductRepositoryInterface;
use App\Api\Shared\Infrastructure\Persistence\DataSource\CoinbaseApiDataSource;

final readonly class SearchProductsQueryHandler
{
    public function __construct(
        private ProductRepositoryInterface $repository,
        private CoinbaseApiDataSource $dataSource
    )
    {
    }

    public function __invoke(SearchProductsQuery $query): array
    {
        $products = $this->repository->findAllWithFilters(
            $query->getCellarId(),
            $query->getOriginId(),
            $query->getBrandId(),
            $query->getDenominationId(),
            $query->getMinPrice(),
            $query->getMaxPrice(),
            $query->getLimit()
        );

        foreach ($products as $product) {
            $product->setLocalPrice($this->deduceLocalPrice($query, $product->getPrice()), $query->getSymbol());
        }

        return $products;
    }

    private function deduceLocalPrice(SearchProductsQuery $query, float $price): string
    {
        $rate = $this->dataSource->getCurrencyRate($query->getCurrency());
        return \number_format($rate * $price, 2, ',', '.');
    }
}