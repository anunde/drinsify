<?php

namespace App\Api\Shared\Infrastructure\ArgumentResolver;

use App\Api\Auth\Infrastructure\Security\UserAdapter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Security\Core\Security;

readonly class UserIdValueResolver implements ArgumentValueResolverInterface
{
    public function __construct(
        private Security $security
    )
    {
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return $argument->getName() === 'userId';
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable|\Generator
    {
        $user = $this->security->getUser();

        if(!$user instanceof UserAdapter) {
            throw new \LogicException('The user is not logger in');
        }

        yield $user->getId();
    }
}