<?php

namespace App\Api\Auth\Application\ResetUserPasswordRequest;

use App\Api\Auth\Domain\Event\UserRequestResetPasswordEvent;
use App\Api\Auth\Domain\Message\UserRequestResetPasswordMessage;
use App\Api\Auth\Domain\Repository\UserRepositoryInterface;
use App\Api\Shared\Domain\Event\EventDispatcherInterface;

final readonly class ResetUserPasswordRequestCommandHandler
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private EventDispatcherInterface $dispatcher
    )
    {
    }

    public function __invoke(ResetUserPasswordRequestCommand $command): void
    {
        $user = $this->userRepository->findOneByEmailOrFail($command->getEmail());
        $user->generateResetPasswordToken();
        $this->userRepository->save($user);

        $this->dispatcher->dispatch(
            new UserRequestResetPasswordEvent(
                $user->getId(),
                $user->getName(),
                $user->getEmail(),
                $user->getResetPasswordToken()
            )
        );
    }
}