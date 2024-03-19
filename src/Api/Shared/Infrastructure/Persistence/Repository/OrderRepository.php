<?php

namespace App\Api\Shared\Infrastructure\Persistence\Repository;

use App\Api\Checkout\Domain\Entity\Order;
use App\Api\Checkout\Domain\Entity\OrderLine;
use App\Api\Shared\Domain\Entity\Token;
use App\Api\Shared\Domain\Exception\ConflictException;
use App\Api\Shared\Domain\Exception\NotFoundException;
use App\Api\Shared\Domain\Repository\OrderRepositoryInterface;
use App\Api\Shared\Infrastructure\Persistence\DataSource\DoctrineDataSource;
use Doctrine\ORM\NonUniqueResultException;

readonly class OrderRepository implements OrderRepositoryInterface
{
    public function __construct(
        private DoctrineDataSource $dataSource
    )
    {
    }

    public function save(Order $order): void
    {
        foreach ($order->getLines() as $line) {
            $this->dataSource->persist($line, true);
        }

        $this->dataSource->persist($order, true);
    }

    /**
     * @throws NonUniqueResultException
     * @throws ConflictException
     */
    public function checkIfNotExistsActivatedOrder(string $userId): void
    {
        $queryBuilder = $this->dataSource->entityManager()->createQueryBuilder();

        $queryBuilder->select('o')
            ->from(Order::class, 'o')
            ->where('o.userId = :userId')
            ->andWhere('o.status.value = 1')
            ->andWhere('o.paid.value = 0')
            ->setParameter('userId', $userId);

        if (null !== $queryBuilder->getQuery()->getOneOrNullResult()) {
            throw new ConflictException('User still have an unclosed order. Please, try it again later');
        }
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findOneByUserId(string $userId): ?Order
    {
        $queryBuilder = $this->dataSource->entityManager()->createQueryBuilder();

        $queryBuilder->select('o')
            ->from(Order::class, 'o')
            ->where('o.userId = :userId')
            ->andWhere('o.status.value = 1')
            ->andWhere('o.paid.value = 0')
            ->setParameter('userId', $userId);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findOneByInternalReferenceOrFail(string $internalReference): Order
    {
        $queryBuilder = $this->dataSource->entityManager()->createQueryBuilder();

        $queryBuilder->select('o')
            ->from(Order::class, 'o')
            ->where('o.internalReference.value = :internalReference')
            ->andWhere('o.status.value = 1')
            ->andWhere('o.paid.value = 0')
            ->setParameter('internalReference', $internalReference);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findOnePaidByUserIdAndInternalReference(string $userId, string $internalReference): Order
    {
        $queryBuilder = $this->dataSource->entityManager()->createQueryBuilder();

        $queryBuilder->select('o')
            ->from(Order::class, 'o')
            ->where('o.internalReference.value = :internalReference')
            ->andWhere('o.userId = :userId')
            ->andWhere('o.status.value = 1')
            ->andWhere('o.paid.value = 1')
            ->setParameter('internalReference', $internalReference)
            ->setParameter('userId', $userId);

        $order = $queryBuilder->getQuery()->getOneOrNullResult();

        $queryBuilderLines = $this->dataSource->entityManager()->createQueryBuilder();

        $queryBuilderLines->select('ol')
            ->from(OrderLine::class, 'ol')
            ->where('ol.orderId = :orderId')
            ->setParameter('orderId', $order->getId()->value());

        $lines = $queryBuilderLines->getQuery()->getResult();

        $order->setLines($lines);

        return $order;
    }

    public function findOpenedOrders(): array
    {
        $queryBuilder = $this->dataSource->entityManager()->createQueryBuilder();

        $queryBuilder->select('o')
            ->from(Order::class, 'o')
            ->where('o.status.value = 1')
            ->andWhere('o.tokenized.value = 0');

        $queryBuilder->setMaxResults(20);
        $orders = $queryBuilder->getQuery()->getResult();

        foreach($orders as $order) {
            $queryBuilderLines = $this->dataSource->entityManager()->createQueryBuilder();

            $queryBuilderLines->select('ol')
                ->from(OrderLine::class, 'ol')
                ->where('ol.orderId = :orderId')
                ->setParameter('orderId', $order->getId()->value());

            $lines = $queryBuilderLines->getQuery()->getResult();

            $order->setLines($lines);
        }

        return $orders;
    }
}