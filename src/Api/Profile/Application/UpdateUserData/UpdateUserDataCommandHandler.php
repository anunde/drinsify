<?php

namespace App\Api\Profile\Application\UpdateUserData;

use App\Api\Auth\Domain\Entity\User\UserBusinessName;
use App\Api\Auth\Domain\Entity\User\UserCuit;
use App\Api\Auth\Domain\Entity\User\UserEmail;
use App\Api\Auth\Domain\Entity\User\UserMetamaskAddress;
use App\Api\Auth\Domain\Entity\User\UserName;
use App\Api\Auth\Domain\Entity\User\UserPhone;
use App\Api\Auth\Domain\Entity\User\UserResidence;
use App\Api\Auth\Domain\Repository\UserRepositoryInterface;
use App\Api\Shared\Domain\Exception\NotFoundException;

final readonly class UpdateUserDataCommandHandler
{
    public function __construct(
        private UserRepositoryInterface $repository
    )
    {
    }

    /**
     * @throws NotFoundException
     */
    public function __invoke(UpdateUserDataCommand $command): void
    {
        if (null === $user = $this->repository->findOneById($command->getId())) {
            throw new NotFoundException('User not found');
        }

        $user->updateData(
            new UserName($command->getName()),
            new UserEmail($command->getEmail()),
            new UserPhone($command->getPhone()),
            new UserResidence($command->getResidence()),
            $command->getBusinessName() ? new UserBusinessName($command->getBusinessName()) : null,
            $command->getCuit() ? new UserCuit($command->getCuit()) : null,
            $command->getMetamaskAddress() ? new UserMetamaskAddress($command->getMetamaskAddress()) : null
        );

        $this->repository->save($user);
    }
}