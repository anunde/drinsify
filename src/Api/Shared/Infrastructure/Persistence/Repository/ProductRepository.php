<?php

namespace App\Api\Shared\Infrastructure\Persistence\Repository;

use App\Api\Catalogue\Domain\Entity\BrandId;
use App\Api\Catalogue\Domain\Entity\DenominationId;
use App\Api\Catalogue\Domain\Entity\OriginId;
use App\Api\Catalogue\Domain\Read\ProductDetailDTO;
use App\Api\Catalogue\Domain\Read\ProductItemListDTO;
use App\Api\Shared\Domain\Entity\CellarId;
use App\Api\Shared\Domain\Entity\Product;
use App\Api\Shared\Domain\Exception\NotFoundException;
use App\Api\Shared\Domain\Repository\ProductRepositoryInterface;
use App\Api\Shared\Infrastructure\Persistence\DataSource\DoctrineDataSource;
use Doctrine\Common\Collections\Criteria;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

readonly class ProductRepository implements ProductRepositoryInterface
{
    public function __construct(
        private DoctrineDataSource $doctrineDataSource
    )
    {
    }

    public function save(Product $product): void
    {
        $this->doctrineDataSource->persist($product, true);
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findOneWriteById(string $id): Product
    {
        $queryBuilder = $this->doctrineDataSource->entityManager()->createQueryBuilder();

        $queryBuilder->select('p')
            ->from(Product::class, 'p')
            ->where('p.status = 1')
            ->andWhere('p.id = :productId')
            ->setParameter('productId', $id);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findOneById(string $id): ?ProductDetailDTO
    {
        /** @var Connection $conn */
        $conn = $this->doctrineDataSource->entityManager()->getConnection();

        $queryBuilder = $conn->createQueryBuilder();

        $queryBuilder
            ->select('p.*', 'pi.*','c.name as cellarName')
            ->from('product', 'p')
            ->leftJoin('p', 'product_info', 'pi', 'p.id = pi.product_id')
            ->leftJoin('p', 'cellar', 'c', 'p.cellar_id = c.id')
            ->where('p.id = :id')
            ->andWhere('p.status = 1')
            ->setParameter('id', $id);

        $result = $queryBuilder->execute()->fetch();

        return ProductDetailDTO::create(
            $result['name'],
            $result['cellarName'],
            $result['description'],
            $result['price'],
            $result['features'],
            $result['image'],
            $result['data_sheet'],
            $result['awards'],
            $result['existence_proof']
        );
    }

    /**
     * @throws Exception
     */
    public function findAllWithFilters(
        ?string $cellarId,
        ?string $originId,
        ?string $brandId,
        ?string $denominationId,
        ?float $minPrice,
        ?float $maxPrice,
        ?int $limit
    ): array
    {
        /** @var Connection $conn */
        $conn = $this->doctrineDataSource->entityManager()->getConnection();

        $queryBuilder = $conn->createQueryBuilder();

        $queryBuilder
            ->select('p.*', 'c.name as cellarName')
            ->from('product', 'p')
            ->leftJoin('p', 'cellar', 'c', 'p.cellar_id = c.id')
            ->where('p.status = 1');

        if (!\is_null($cellarId)) {
            $queryBuilder->andWhere('p.cellar_id = :cellarId')
                ->setParameter('cellarId', $cellarId);
        }

        if (!\is_null($originId)) {
            $queryBuilder->andWhere('p.origin_id = :originId')
                ->setParameter('originId', $originId);
        }

        if (!\is_null($brandId)) {
            $queryBuilder->andWhere('p.brand_id = :brandId')
                ->setParameter('brandId', $brandId);
        }

        if (!\is_null($denominationId)) {
            $queryBuilder->andWhere('p.denomination_id = :denominationId')
                ->setParameter('denominationId', $denominationId);
        }

        if (!\is_null($minPrice)) {
            $queryBuilder->andWhere('p.price >= :minPrice')
                ->setParameter('minPrice', $minPrice);
        }

        if (!\is_null($maxPrice)) {
            $queryBuilder->andWhere('p.price <= :maxPrice')
                ->setParameter('maxPrice', $maxPrice);
        }

        if (!\is_null($limit) && is_numeric($limit)) {
            $queryBuilder->setMaxResults($limit);
        }

        $results = $queryBuilder->execute()->fetchAll();

        $products = [];
        foreach ($results as $result) {
            $product = ProductItemListDTO::create(
                $result['id'],
                $result['name'],
                $result['cellarName'],
                $result['thumbnail'],
                $result['price'],
                $result['quantity']
            );

            $products[] = $product;
        }

        return $products;
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException|NotFoundException
     */
    public function checkProductExistOrFail(string $id): void
    {
        $queryBuilder = $this->doctrineDataSource->entityManager()->createQueryBuilder();

        $queryBuilder->select('count(p.id)')
            ->from(Product::class, 'p')
            ->where('p.id = :id')
            ->andWhere('p.status = 1')
            ->setParameter('id', $id);

        if( 0 === $count = $queryBuilder->getQuery()->getSingleScalarResult()) {
            throw new NotFoundException(\sprintf('Product with id %s, not found', $id));
        }

    }
}