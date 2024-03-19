<?php

namespace App\Api\Auth\Application\RestoreUserToken;

use App\Api\Auth\Domain\Event\UserRegisteredEvent;
use App\Api\Auth\Domain\Exception\UserIsActiveException;
use App\Api\Auth\Domain\Message\UserRegisterMessage;
use App\Api\Auth\Domain\Repository\UserRepositoryInterface;
use App\Api\Shared\Domain\Event\EventDispatcherInterface;

final readonly class RestoreUserTokenCommandHandler
{
    public function __construct(
        private UserRepositoryInterface  $userRepository,
        private EventDispatcherInterface $dispatcher
    )
    {
    }

    /**
     * @throws UserIsActiveException
     */
    public function __invoke(RestoreUserTokenCommand $command): void
    {
        $email = $command->getEmail();
        $user = $this->userRepository->findOneByEmailOrFail($email);

        if($user->isActivated()) {
            throw new UserIsActiveException(\sprintf('The email %s is already activated', $email));
        }

        $user->generateToken();
        $this->userRepository->save($user);
        $this->dispatcher->dispatch(new UserRegisteredEvent(
            new UserRegisterMessage(
                $user->getId(),
                $user->getEmail(),
                $user->getName(),
                $user->getToken()
            )
        ));
    }
}