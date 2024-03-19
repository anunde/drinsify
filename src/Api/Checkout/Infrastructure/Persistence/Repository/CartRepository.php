<?php

namespace App\Api\Checkout\Infrastructure\Persistence\Repository;

use App\Api\Checkout\Domain\Entity\Cart;
use App\Api\Checkout\Domain\Entity\CartLine;
use App\Api\Checkout\Domain\Repository\CartRepositoryInterface;
use App\Api\Shared\Domain\Entity\Product;
use App\Api\Shared\Domain\Exception\NotFoundException;
use App\Api\Shared\Infrastructure\Persistence\DataSource\DoctrineDataSource;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\NonUniqueResultException;

class CartRepository implements CartRepositoryInterface
{
    public function __construct(
        private readonly DoctrineDataSource $dataSource
    )
    {
    }

    public function save(Cart $cart): void
    {
        foreach ($cart->getLines() as $line) {
            $this->dataSource->persist($line, true);
        }

        $cart->updateTimestamps();
        $this->dataSource->persist($cart, true);
    }

    public function clearAndPersist(Cart $cart): Cart
    {
        foreach ($cart->getLines() as $line) {
            if (0 >= $line->getQuantity()->value()) {
                $cart->removeLine($line->getProductId());
                $this->dataSource->remove($line, true);
                continue;
            }

            $this->dataSource->persist($line, true);
        }

        $cart->updateTimestamps();
        $this->dataSource->persist($cart, true);
        return $cart;
    }

    public function clear(Cart $cart): void
    {
        foreach ($cart->getLines() as $line) {
            $this->dataSource->remove($line, true);
        }

        $this->dataSource->remove($cart, true);
    }

    public function remove(Cart $cart): void
    {
        $this->dataSource->remove($cart, true);
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findOneByUserId(string $userId): ?Cart
    {
        $queryBuilder = $this->dataSource->entityManager()->createQueryBuilder();

        $queryBuilder->select('c')
            ->from(Cart::class, 'c')
            ->where('c.userId = :userId')
            ->setParameter('userId', $userId);

        if (null === $cart = $queryBuilder->getQuery()->getOneOrNullResult()) {
            return null;
        }

        $queryBuilderLine = $this->dataSource->entityManager()->createQueryBuilder();
        $queryBuilderLine->select('cl')
            ->from(CartLine::class, 'cl')
            ->where('cl.cartId = :cartId')
            ->setParameter('cartId', $cart->getId());

        $cart->setLines($queryBuilderLine->getQuery()->getResult());

        return $cart;
    }

    /**
     * @throws NonUniqueResultException
     * @throws NotFoundException
     */
    public function checkIfLineExistsByProductIdOrFail(string $productId): void
    {
        $queryBuilder = $this->dataSource->entityManager()->createQueryBuilder();

        $queryBuilder->select('cl')
            ->from(CartLine::class, 'cl')
            ->where('cl.productId = :productId')
            ->setParameter('productId', $productId);

        if (null === $queryBuilder->getQuery()->getOneOrNullResult()) {
            throw new NotFoundException(\sprintf('Line with id %s not found', $productId));
        }
    }

    /**
     * @throws NonUniqueResultException
     * @throws NotFoundException
     */
    public function findOneWithLinesOrFail(string $userId): Cart
    {
        $queryBuilder = $this->dataSource->entityManager()->createQueryBuilder();

        $queryBuilder->select('c')
            ->from(Cart::class, 'c')
            ->where('c.userId = :userId')
            ->setParameter('userId', $userId);

        if (null === $cart = $queryBuilder->getQuery()->getOneOrNullResult()) {
            throw new NotFoundException('Cart not found');
        }

        $queryBuilderLine = $this->dataSource->entityManager()->createQueryBuilder();
        $queryBuilderLine->select('cl')
            ->from(CartLine::class, 'cl')
            ->where('cl.cartId = :cartId')
            ->setParameter('cartId', $cart->getId());

        if (1 > $lines = $queryBuilderLine->getQuery()->getResult()) {
            throw new NotFoundException('Cart without lines');
        }

        $cart->setLines($lines);

        return $cart;
    }

    /**
     * @throws Exception
     */
    public function findOneWithProductsArray(string $userId): array
    {
        $sql = "SELECT
                p.id,
                p.name,
                p.thumbnail,
                p.price,
                p.taxes,
                cl.quantity
            FROM cart c
            LEFT JOIN cart_lines cl
            ON c.id = cl.cartId
            LEFT JOIN product p
            ON cl.productId = p.id
            WHERE c.userId = :userId
        ";

        $conn = $this->dataSource->entityManager()->getConnection();
        $stmt = $conn->executeQuery($sql, ['userId' => $userId]);
        return $stmt->fetchAll();
    }

    public function findAllHaveToExpire(): array
    {
        $date = new \DateTime();
        $date->modify('-30 minutes');
        $queryBuilder = $this->dataSource->entityManager()->createQueryBuilder();
        $queryBuilder->select('c')
            ->from(Cart::class, 'c')
            ->where('c.updatedAt.value <= :date')
            ->setParameter('date', $date)
            ->setMaxResults(10);

        $queryBuilder->getQuery()->getResult();

        $carts = $queryBuilder->getQuery()->getResult();

        if (empty($carts)) {
            return [];
        }

        foreach($carts as $cart) {
            $queryBuilderLines = $this->dataSource->entityManager()->createQueryBuilder();

            $queryBuilderLines->select('cl')
                ->from(CartLine::class, 'cl')
                ->where('cl.cartId = :cartId')
                ->setParameter('cartId', $cart->getId()->value());

            $lines = $queryBuilderLines->getQuery()->getResult();

            $cart->setLines($lines);
        }

        return $carts;
    }

    /**
     * @throws NonUniqueResultException
     * @throws NotFoundException
     */
    public function findOneWithLinesAndProductInfoOrFail(string $userId): Cart
    {
        $queryBuilder = $this->dataSource->entityManager()->createQueryBuilder();

        $queryBuilder->select('c')
            ->from(Cart::class, 'c')
            ->where('c.userId = :userId')
            ->setParameter('userId', $userId);

        if (null === $cart = $queryBuilder->getQuery()->getOneOrNullResult()) {
            throw new NotFoundException('Cart not found');
        }

        $sql = "SELECT
                cl.*,
                p.price,
                p.taxes
            FROM cart_lines cl
            LEFT JOIN cart c
            ON c.id = cl.cartId
            LEFT JOIN product p
            ON cl.productId = p.id
            WHERE c.userId = :userId
        ";

        $conn = $this->dataSource->entityManager()->getConnection();
        $stmt = $conn->executeQuery($sql, ['userId' => $userId]);

        if (1 > $lines = $stmt->fetchAll()) {
            throw new NotFoundException('Cart without lines');
        }

        $cart->setLines($lines);

        return $cart;
    }
}