<?php

namespace App\Api\Auth\Infrastructure\Persistence\Repository;
use App\Api\Auth\Domain\Entity\User\User;
use App\Api\Auth\Domain\Repository\UserRepositoryInterface;
use App\Api\Shared\Domain\Exception\NotFoundException;
use App\Api\Shared\Infrastructure\Persistence\DataSource\DoctrineDataSource;
use Doctrine\ORM\NonUniqueResultException;

class UserRepository implements UserRepositoryInterface
{
    private DoctrineDataSource $doctrineDataSource;

    public function __construct(DoctrineDataSource $doctrineDataSource)
    {
        $this->doctrineDataSource = $doctrineDataSource;
    }

    public function save(User $user): void
    {
        $this->doctrineDataSource->persist($user, true);
    }

    /**
     * @throws NonUniqueResultException
     */
    public function checkUserExists(string $email): bool
    {
        $queryBuilder = $this->doctrineDataSource->entityManager()->createQueryBuilder();

        $queryBuilder->select('u')
            ->from(User::class, 'u')
            ->where('u.email = :email')
            ->setParameter('email', $email);

        if (null === $queryBuilder->getQuery()->getOneOrNullResult()) {
            return false;
        }

        return true;
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findOneById(string $id): ?User
    {
        $queryBuilder = $this->doctrineDataSource->entityManager()->createQueryBuilder();

        $queryBuilder->select('u')
            ->from(User::class, 'u')
            ->where('u.id = :userId')
            ->setParameter('userId', $id);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }


    /**
     * @throws NonUniqueResultException
     * @throws NotFoundException
     */
    public function findOneByEmailOrFail(string $email): User
    {
        $queryBuilder = $this->doctrineDataSource->entityManager()->createQueryBuilder();

        $queryBuilder->select('u')
            ->from(User::class, 'u')
            ->where('u.email = :email')
            ->setParameter('email', $email);

        if (null === $user = $queryBuilder->getQuery()->getOneOrNullResult()) {
            throw new NotFoundException(\sprintf('User not found by email %s', $email));
        }

        return $user;
    }

    /**
     * @throws NonUniqueResultException
     * @throws NotFoundException
     */
    public function findOneUserInactiveByIdAndTokenOrFail(string $id, string $token): User
    {
        $queryBuilder = $this->doctrineDataSource->entityManager()->createQueryBuilder();

        $queryBuilder->select('u')
            ->from(User::class, 'u')
            ->where('u.id = :id')
            ->setParameter('id', $id)
            ->andWhere('u.token = :token')
            ->setParameter('token', $token)
            ->andHaving('u.activated = 0');

        if (null === $user = $queryBuilder->getQuery()->getOneOrNullResult()) {
            throw new NotFoundException(\sprintf('User not found by id %s and token %s', $id, $token));
        }

        return $user;
    }

    /**
     * @throws NonUniqueResultException
     * @throws NotFoundException
     */
    public function findOneUserByIdAndResetPasswordTokenOrFail(string $id, string $resetPasswordToken): User
    {
        $queryBuilder = $this->doctrineDataSource->entityManager()->createQueryBuilder();

        $queryBuilder->select('u')
            ->from(User::class, 'u')
            ->where('u.id = :id')
            ->setParameter('id', $id)
            ->andWhere('u.resetPasswordToken = :token')
            ->setParameter('token', $resetPasswordToken);

        if (null === $user = $queryBuilder->getQuery()->getOneOrNullResult()) {
            throw new NotFoundException(\sprintf('User not found by id %s and reset password token %s', $id, $resetPasswordToken));
        }

        return $user;
    }
}