<?php

namespace App\Api\Auth\Infrastructure\Security;

use App\Api\Auth\Domain\Entity\User\User;
use App\Api\Auth\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

readonly class UserProvider implements UserProviderInterface
{
    public function __construct(
        private UserRepositoryInterface $repository
    )
    {
    }

    public function loadUserByUsername(string $username): UserAdapter
    {
        $user =  $this->repository->findOneByEmailOrFail($username);
        return new UserAdapter($user);
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof UserAdapter) {
            throw new \InvalidArgumentException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        return $user;
    }

    public function supportsClass(string $class): bool
    {
        return $class === User::class;
    }
}