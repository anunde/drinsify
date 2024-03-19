<?php

namespace App\Api\Shared\Domain\Repository;

use App\Api\Catalogue\Domain\Read\ProductDetailDTO;
use App\Api\Shared\Domain\Entity\Product;

interface ProductRepositoryInterface
{
    public function save(Product $product): void;

    public function findOneWriteById(string $id): Product;

    public function findOneById(string $id): ?ProductDetailDTO;

    public function checkProductExistOrFail(string $id): void;

    public function findAllWithFilters(
        ?string $cellarId,
        ?string $originId,
        ?string $brandId,
        ?string $denominationId,
        ?float $minPrice,
        ?float $maxPrice,
        ?int $limit
    ): array;
}