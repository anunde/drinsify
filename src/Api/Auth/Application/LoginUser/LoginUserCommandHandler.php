<?php

namespace App\Api\Auth\Application\LoginUser;

use App\Api\Auth\Domain\Exception\UserIsNotActivatedException;
use App\Api\Auth\Domain\Exception\UserUnauthorizedException;
use App\Api\Auth\Domain\Repository\UserRepositoryInterface;
use App\Api\Auth\Domain\Service\JWTEncoderInterface;
use App\Api\Auth\Domain\Service\PasswordEncoder;

readonly class LoginUserCommandHandler
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private PasswordEncoder         $encoder,
        private JWTEncoderInterface     $jwtEncoder
    )
    {
    }

    /**
     * @throws UserUnauthorizedException
     * @throws UserIsNotActivatedException
     */
    public function __invoke(LoginUserCommand $command): string
    {
        $user = $this->userRepository->findOneByEmailOrFail($command->getEmail());

        if (!$this->encoder->isValid($command->getPassword(), $user->getPassword())) {
            throw new UserUnauthorizedException('Invalid credentials');
        }

        if (!$user->getActivated()) {
            throw new UserIsNotActivatedException('User is not activated. Please, active the account');
        }

        return $this->jwtEncoder->encode([
            'username' => $user->getEmail(),
            'exp' => time() + 43200
        ]);
    }
}