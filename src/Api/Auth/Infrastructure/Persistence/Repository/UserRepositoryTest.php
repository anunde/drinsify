<?php

namespace App\Api\Auth\Infrastructure\Persistence\Repository;

use App\Api\Auth\Domain\Entity\User\User;
use App\Api\Auth\Domain\Repository\UserRepositoryInterface;
use App\Api\Shared\Domain\Exception\NotFoundException;
use App\Api\Shared\Infrastructure\Persistence\DataSource\InMemoryDataSource;

class UserRepositoryTest implements UserRepositoryInterface
{
    private array $users = [];
    public function searchById(string $id): ?User
    {
        $userArray = InMemoryDataSource::$data['Api']['users'][$id] ?? null;

        if($userArray == null) {
            return null;
        }

        return User::fromPrimitives($userArray);
    }

    public function save(User $user): void
    {
        $this->users[] = $user;
    }

    public function checkUserExists(string $email): bool
    {
        $userArray = InMemoryDataSource::$data['Api']['users'];

        $result = array_filter($userArray, function ($user) use ($email) {
           return $user['email'] === $email;
        });

        if(empty($result)) {
            return false;
        }

        return true;
    }

    /**
     * @throws \Exception
     */
    public function findOneByEmailOrFail(string $email): User
    {
        $userArray = InMemoryDataSource::$data['Api']['users'];

        $result = array_filter($userArray, function ($user) use ($email) {
            return $user['email'] === $email;
        });

        if (empty($result)) {
            throw new \App\Api\Shared\Domain\Exception\NotFoundException(\sprintf('User not found by email %s', $email));
        }

        return User::fromPrimitives(current($result));
    }

    /**
     * @throws \Exception
     */
    public function findOneUserInactiveByIdAndTokenOrFail(string $id, string $token): User
    {
        $userArray = InMemoryDataSource::$data['Api']['users'];

        $result = array_filter($userArray, function ($user) use ($id, $token) {
            return $user['id'] === $id && $user['token'] === $token;
        });

        if (empty($result)) {
            throw new \App\Api\Shared\Domain\Exception\NotFoundException(\sprintf('User not found by id %s and token %s', $id, $token));
        }

        return User::fromPrimitives(current($result));
    }

    /**
     * @throws NotFoundException
     */
    public function findOneUserByIdAndResetPasswordTokenOrFail(string $id, string $resetPasswordToken): User
    {
        $userArray = InMemoryDataSource::$data['Api']['users'];

        $result = array_filter($userArray, function ($user) use ($id, $resetPasswordToken) {
            return $user['id'] === $id && $user['reset_password_token'] === $resetPasswordToken;
        });

        if (empty($result)) {
            throw new \App\Api\Shared\Domain\Exception\NotFoundException(\sprintf('User not found by id %s and reset password token %s', $id, $resetPasswordToken));
        }

        return User::fromPrimitives(current($result));
    }

    public function findOneById(string $id): ?User
    {
        // TODO: Implement findOneById() method.
    }
}