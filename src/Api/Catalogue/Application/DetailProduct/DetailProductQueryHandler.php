<?php

namespace App\Api\Catalogue\Application\DetailProduct;

use App\Api\Catalogue\Domain\Read\ProductDetailDTO;
use App\Api\Shared\Domain\DataSource\CoinbaseApiDataSourceInterface;
use App\Api\Shared\Domain\Exception\NotFoundException;
use App\Api\Shared\Domain\Repository\ProductRepositoryInterface;

final readonly class DetailProductQueryHandler
{
    public function __construct(
        private ProductRepositoryInterface $repository,
        private CoinbaseApiDataSourceInterface $dataSource
    )
    {
    }

    /**
     * @throws NotFoundException
     */
    public function __invoke(DetailProductQuery $query): ProductDetailDTO
    {
        if (null === $product = $this->repository->findOneById($query->getId())) {
            throw new NotFoundException(\sprintf('Product with id %s, not found', $query->getId()));
        }

        $product->setLocalPrice($this->deduceLocalPrice($query, $product->getPrice()), $query->getSymbol());

        return $product;
    }

    private function deduceLocalPrice(DetailProductQuery $query, float $price): string
    {
        $rate = $this->dataSource->getCurrencyRate($query->getCurrency());
        return \number_format($rate * $price, 2, ',', '.');
    }
}