<?php

namespace App\Api\Shared\Infrastructure\Persistence\Repository;

use App\Api\Catalogue\Domain\Entity\BrandId;
use App\Api\Catalogue\Domain\Entity\DenominationId;
use App\Api\Catalogue\Domain\Entity\OriginId;
use App\Api\Catalogue\Domain\Read\ProductDetailDTO;
use App\Api\Shared\Domain\Entity\CellarId;
use App\Api\Shared\Domain\Entity\Product;
use App\Api\Shared\Domain\Exception\NotFoundException;
use App\Api\Shared\Domain\Repository\ProductRepositoryInterface;
use App\Api\Shared\Infrastructure\Persistence\DataSource\InMemoryDataSource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;

class ProductRepositoryTest implements ProductRepositoryInterface
{
    private array $products = [];
    public function save(Product $product): void
    {
        $this->products[] = $product;
    }

    public function findOneWriteById(string $id): Product
    {
        // TODO: Implement findOneWriteById() method.
    }


    public function findAllWithFilters(?string $cellarId, ?string $originId, ?string $brandId, ?string $denominationId, ?float $minPrice, ?float $maxPrice, ?int $limit): array
    {
        $productData = InMemoryDataSource::$data['Api']['products'];
        $productCollection = new ArrayCollection($productData);

        $criteria = Criteria::create();

        if (!is_null($cellarId)) {
            $criteria->andWhere(Criteria::expr()->eq('cellarId', new CellarId($cellarId)));
        }

        if (!is_null($originId)) {
            $criteria->andWhere(Criteria::expr()->eq('originId', new OriginId($originId)));
        }

        if (!is_null($brandId)) {
            $criteria->andWhere(Criteria::expr()->eq('brandId', new BrandId($brandId)));
        }

        if (!is_null($denominationId)) {
            $criteria->andWhere(Criteria::expr()->eq('denominationId', new DenominationId($denominationId)));
        }

        if (!is_null($minPrice)) {
            $criteria->andWhere(Criteria::expr()->gte('price.value', $minPrice));
        }

        if (!is_null($maxPrice)) {
            $criteria->andWhere(Criteria::expr()->lte('price.value', $maxPrice));
        }

        return $productCollection->matching($criteria)->toArray();
    }


    /**
     * @throws NotFoundException
     */
    public function checkProductExistOrFail(string $id): void
    {
        $productData = InMemoryDataSource::$data['Api']['products'];

        $result = \array_filter($productData, function ($product) use ($id) {
            return $product['id'] === $id;
        });

        if(empty($result)) {
            throw new NotFoundException(\sprintf('Product with id %s, not found', $id));
        }
    }

    public function findOneById(string $id): ?ProductDetailDTO
    {
        // TODO: Implement findOneById() method.
    }
}