<?php

namespace App\Api\Auth\Infrastructure\Controller;

use App\Api\Auth\Application\ResetUserPassword\ResetUserPasswordCommand;
use App\Api\Auth\Application\ResetUserPassword\ResetUserPasswordCommandHandler;
use App\Api\Auth\Infrastructure\Exception\AuthErrorHandler;
use App\Api\Shared\Infrastructure\Service\RequestService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ResetUserPassword extends AbstractController
{
    public function __construct(
        private readonly AuthErrorHandler $errorHandler,
        private readonly ResetUserPasswordCommandHandler $commandHandler
    )
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $this->commandHandler->__invoke(
                new ResetUserPasswordCommand(
                    RequestService::getField($request, 'uid'),
                    RequestService::getField($request, 'token'),
                    RequestService::getField($request, 'password')
                )
            );

            return new JsonResponse([
               'status' => 'ok',
               'message' => 'Password changed successfully!'
            ]);

        } catch (\Throwable $th) {
            return $this->errorHandler->handle($th);
        }
    }
}