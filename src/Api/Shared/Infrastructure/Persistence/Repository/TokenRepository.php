<?php

namespace App\Api\Shared\Infrastructure\Persistence\Repository;

use App\Api\Catalogue\Domain\Read\ProductDetailDTO;
use App\Api\Catalogue\Domain\Read\ProductItemListDTO;
use App\Api\Catalogue\Domain\Read\TokenDetailDTO;
use App\Api\Catalogue\Domain\Read\TokenItemListDTO;
use App\Api\Shared\Domain\Entity\Cellar;
use App\Api\Shared\Domain\Entity\Product;
use App\Api\Shared\Domain\Entity\Token;
use App\Api\Shared\Domain\Repository\TokenRepositoryInterface;
use App\Api\Shared\Infrastructure\Persistence\DataSource\DoctrineDataSource;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\NonUniqueResultException;

final readonly class TokenRepository implements TokenRepositoryInterface
{
    public function __construct(
        private DoctrineDataSource $dataSource
    )
    {
    }

    public function save(Token $token): void
    {
        $this->dataSource->persist($token, true);
    }


    public function findByUser(string $userId): array
    {
        $queryBuilder = $this->dataSource->entityManager()->createQueryBuilder();

        $queryBuilder->select('t', 'p', 'c.name as cellarName')
            ->from(Token::class, 't')
            ->join('t.product', 'p')
            ->leftJoin(Cellar::class, 'c', 'WITH', 'p.cellarId = c.id')
            ->where('t.userId = :userId')
            ->setParameter('userId', $userId);

        $results = $queryBuilder->getQuery()->getResult();

        $tokensWithCellarName = [];
        foreach ($results as $result) {
            $token = $result[0];
            $tokenData = [
                'token' => $token,
                'cellarName' => $result['cellarName']
            ];
            $tokensWithCellarName[] = $tokenData;
        }

        return $tokensWithCellarName;
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findById(string $id): ?Token
    {
        $queryBuilder = $this->dataSource->entityManager()->createQueryBuilder();

        $queryBuilder->select('t')
            ->from(Token::class, 't')
            ->where('t.id = :tokenId')
            ->setParameter('tokenId', $id);

        return $queryBuilder->getQuery()->getOneOrNullResult();
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
        $conn = $this->dataSource->entityManager()->getConnection();

        $queryBuilder = $conn->createQueryBuilder();

        $queryBuilder
            ->select('t.id', 't.price', 'p.name', 'p.thumbnail', 'c.name as cellarName')
            ->from('token', 't')
            ->leftJoin('t', 'product', 'p', 't.product_id = p.id')
            ->leftJoin('p', 'cellar', 'c', 'p.cellar_id = c.id')
            ->where('t.in_sale = 1')
            ->andWhere('t.is_requested = 0');

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

        $tokens = [];
        foreach ($results as $result) {
            $token = TokenItemListDTO::create(
                $result['id'],
                $result['name'],
                $result['cellarName'],
                $result['thumbnail'],
                $result['price']
            );

            $tokens[] = $token;
        }

        return $tokens;
    }

    public function findReadById(string $id): ?TokenDetailDTO
    {
        /** @var Connection $conn */
        $conn = $this->dataSource->entityManager()->getConnection();

        $queryBuilder = $conn->createQueryBuilder();

        $queryBuilder
            ->select(
                't.id',
                't.price',
                'p.name',
                'p.description',
                'pi.features',
                'pi.image',
                'pi.data_sheet',
                'pi.awards',
                'pi.existence_proof',
                'c.name as cellarName'
            )
            ->from('token', 't')
            ->leftJoin('t', 'product', 'p', 't.product_id = p.id')
            ->leftJoin('p', 'cellar', 'c', 'p.cellar_id = c.id')
            ->leftJoin('p', 'product_info', 'pi', 'pi.product_id = p.id')
            ->where('t.in_sale = 1')
            ->andWhere('t.is_requested = 0');

        $result = $queryBuilder->execute()->fetch();

        if (!$result) {
            return null;
        }

        return TokenDetailDTO::create(
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
}