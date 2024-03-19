<?php

namespace App\Api\Subscription\Infrastructure\Persistence\Repository;

use App\Api\Shared\Infrastructure\Persistence\DataSource\DoctrineDataSource;
use App\Api\Subscription\Domain\Entity\Subscriber;
use App\Api\Subscription\Domain\Exception\SubscriberAlreadyExistException;
use App\Api\Subscription\Domain\Repository\SubscribeRepositoryInterface;
use Doctrine\ORM\NonUniqueResultException;

class SubscribeRepository implements SubscribeRepositoryInterface
{
    public function __construct(
        private readonly DoctrineDataSource $dataSource
    )
    {
    }

    public function save(Subscriber $subscriber): void
    {
        $this->dataSource->persist($subscriber, true);
    }

    /**
     * @throws NonUniqueResultException
     * @throws SubscriberAlreadyExistException
     */
    public function checkIfNotExistsByEmailOrFail(string $email): void
    {
        $queryBuilder = $this->dataSource->entityManager()->createQueryBuilder();

        $queryBuilder->select('s')
            ->from(Subscriber::class, 's')
            ->where('s.email.value = :email')
            ->setParameter('email', $email);

        if (null !== $queryBuilder->getQuery()->getOneOrNullResult()) {
            throw new SubscriberAlreadyExistException(\sprintf('It already exist a subscriber with this email %s', $email));
        }
    }
}