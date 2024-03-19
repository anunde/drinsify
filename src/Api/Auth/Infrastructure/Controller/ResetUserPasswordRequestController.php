<?php

namespace App\Api\Auth\Infrastructure\Controller;

use App\Api\Auth\Application\ResetUserPasswordRequest\ResetUserPasswordRequestCommand;
use App\Api\Auth\Application\ResetUserPasswordRequest\ResetUserPasswordRequestCommandHandler;
use App\Api\Auth\Infrastructure\Exception\AuthErrorHandler;
use App\Api\Shared\Infrastructure\Service\RequestService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ResetUserPasswordRequestController extends AbstractController
{
    public function __construct(
        private readonly ResetUserPasswordRequestCommandHandler $commandHandler,
        private readonly AuthErrorHandler $errorHandler
    )
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            /** RUN COMMAND */
            $this->commandHandler->__invoke(
                new ResetUserPasswordRequestCommand(
                    RequestService::getField($request, 'email'),
                )
            );

            return new JsonResponse([
                'status' => 'ok',
                'message' => "Generated User reset password token"
            ], 201);

        } catch (\Throwable $th) {
            return $this->errorHandler->handle($th);
        }
    }
}