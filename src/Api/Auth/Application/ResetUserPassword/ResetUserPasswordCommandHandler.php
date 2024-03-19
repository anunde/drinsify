<?php

namespace App\Api\Auth\Application\ResetUserPassword;

use App\Api\Auth\Domain\Repository\UserRepositoryInterface;
use App\Api\Auth\Domain\Service\PasswordEncoder;

readonly class ResetUserPasswordCommandHandler
{
    public function __construct(
        private UserRepositoryInterface $repository,
        private PasswordEncoder         $encoder
    )
    {
    }

    public function __invoke(ResetUserPasswordCommand $command): void
    {
        $user = $this->repository->findOneUserByIdAndResetPasswordTokenOrFail($command->getUid(), $command->getResetPasswordToken());
        $user->resetPassword($this->encoder->encode($command->getPassword()));

        $this->repository->save($user);
    }
}