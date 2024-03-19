<?php

namespace App\Api\Profile\Application\GetUserData;

use App\Api\Auth\Domain\Entity\User\User;
use App\Api\Auth\Domain\Repository\UserRepositoryInterface;
use App\Api\Shared\Domain\Exception\NotFoundException;

final readonly class GetUserDataQueryHandler
{
    public function __construct(
        private UserRepositoryInterface $repository
    )
    {
    }

    /**
     * @throws NotFoundException
     */
    public function __invoke(GetUserDataQuery $query): User
    {
        if(null === $user = $this->repository->findOneById($query->getUserId())) {
            throw new NotFoundException('User not found');
        }

        return $user;
    }
}