<?php

namespace App\Api\Auth\Infrastructure\Controller;

use App\Api\Auth\Application\LoginUser\LoginUserCommand;
use App\Api\Auth\Application\LoginUser\LoginUserCommandHandler;
use App\Api\Auth\Infrastructure\Exception\AuthErrorHandler;
use App\Api\Shared\Infrastructure\Service\RequestService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class LoginUserController extends AbstractController
{
    public function __construct(
        private readonly AuthErrorHandler $errorHandler,
        private readonly LoginUserCommandHandler $commandHandler
    )
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            /** RUN COMMAND */
            $token = $this->commandHandler->__invoke(
                new LoginUserCommand(
                    RequestService::getField($request, 'email'),
                    RequestService::getField($request, 'password')
                )
            );

            return new JsonResponse($token);

        } catch (\Throwable $th) {
            return $this->errorHandler->handle($th);
        }
    }
}