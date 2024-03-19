<?php

namespace App\Api\Auth\Application\ActivateUser;

use App\Api\Auth\Domain\DataSource\UserApiDataSource;
use App\Api\Auth\Domain\Repository\UserRepositoryInterface;

final readonly class ActivateUserCommandHandler
{
    public function __construct(
        private UserRepositoryInterface $repository,
        private UserApiDataSource $dataSource
    )
    {
    }

    public function __invoke(ActivateUserCommand $command): void
    {
        $user = $this->repository->findOneUserInactiveByIdAndTokenOrFail($command->getUid(), $command->getToken());
        $user->activateUser();
        $user->assignNetworkAddress($this->dataSource->createUserAddress());
        $this->repository->save($user);
    }
}