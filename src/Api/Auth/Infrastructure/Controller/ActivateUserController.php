<?php

namespace App\Api\Auth\Infrastructure\Controller;

use App\Api\Auth\Application\ActivateUser\ActivateUserCommand;
use App\Api\Auth\Application\ActivateUser\ActivateUserCommandHandler;
use App\Api\Auth\Infrastructure\Exception\AuthErrorHandler;
use App\Api\Shared\Infrastructure\Service\RequestService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class ActivateUserController extends AbstractController
{
    public function __construct(
        private readonly ActivateUserCommandHandler $commandHandler,
        private readonly AuthErrorHandler $errorHandler
    )
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $this->commandHandler->__invoke(
                new ActivateUserCommand(
                    RequestService::getField($request, 'uid'),
                    RequestService::getField($request, 'token')
                )
            );

            return new JsonResponse([
                'status' => 'ok',
                'message' => 'User activated!'
            ]);
        } catch (\Throwable $th) {
            return $this->errorHandler->handle($th);
        }
    }

}