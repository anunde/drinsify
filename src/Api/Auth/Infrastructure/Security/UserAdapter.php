<?php

namespace App\Api\Auth\Infrastructure\Security;

use App\Api\Auth\Domain\Entity\User\User;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method string getUserIdentifier()
 */
readonly class UserAdapter implements UserInterface
{
    public function __construct(
        private User $user
    )
    {
    }

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function getPassword(): ?string
    {
        return $this->user->getPassword();
    }

    public function getSalt(): null
    {
        return null;
    }

    public function eraseCredentials()
    {
    }

    public function getUsername(): string
    {
        return $this->user->getName();
    }

    public function getId(): string
    {
        return $this->user->getId();
    }

    public function __call(string $name, array $arguments)
    {
        // TODO: Implement @method string getUserIdentifier()
    }
}