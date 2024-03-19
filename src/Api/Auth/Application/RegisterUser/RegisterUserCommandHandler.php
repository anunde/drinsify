<?php

namespace App\Api\Auth\Application\RegisterUser;

use App\Api\Auth\Domain\Entity\User\User;
use App\Api\Auth\Domain\Entity\User\UserBirthdate;
use App\Api\Auth\Domain\Entity\User\UserEmail;
use App\Api\Auth\Domain\Entity\User\UserGender;
use App\Api\Auth\Domain\Entity\User\UserName;
use App\Api\Auth\Domain\Entity\User\UserPassword;
use App\Api\Auth\Domain\Entity\User\UserSurname;
use App\Api\Auth\Domain\Event\UserRegisteredEvent;
use App\Api\Auth\Domain\Exception\UserAlreadyExistsException;
use App\Api\Auth\Domain\Message\UserRegisterMessage;
use App\Api\Auth\Domain\Repository\UserRepositoryInterface;
use App\Api\Auth\Domain\Service\PasswordEncoder;
use App\Api\Shared\Domain\Event\EventDispatcherInterface;

final readonly class RegisterUserCommandHandler
{
    public function __construct(
       private UserRepositoryInterface  $userRepository,
       private EventDispatcherInterface $dispatcher,
       private PasswordEncoder $passwordEncoder
    )
    {
    }

    /**
     * @throws \Exception
     */
    public function __invoke(RegisterUserCommand $command): void
    {
        $email = $command->getEmail();

        if($this->userRepository->checkUserExists($email)) {
            throw new UserAlreadyExistsException(\sprintf('The user with email %s already exists!', $email));
        }

        $user = User::create(
            $command->getName(),
            $command->getSurname(),
            $command->getGender(),
            $command->getEmail(),
            $command->getPhone(),
            $command->getResidence(),
            $command->getCp(),
            $command->getCountry(),
            $command->getCity(),
            $this->passwordEncoder->encode($command->getPassword()),
            $command->getBirthdate()
        );

        $this->userRepository->save($user);
        $this->dispatcher->dispatch(new UserRegisteredEvent($user->getId(), $user->getEmail(), $user->getName(), $user->getToken()));

    }
}