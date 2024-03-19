<?php

namespace App\Api\Auth\Infrastructure\Controller;

use App\Api\Auth\Application\RestoreUserToken\RestoreUserTokenCommand;
use App\Api\Auth\Application\RestoreUserToken\RestoreUserTokenCommandHandler;
use App\Api\Auth\Infrastructure\Exception\AuthErrorHandler;
use App\Api\Shared\Infrastructure\Service\RequestService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class RestoreUserTokenController extends AbstractController
{
    public function __construct(
        private readonly RestoreUserTokenCommandHandler $commandHandler,
        private readonly AuthErrorHandler $errorHandler
    )
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            /** RUN COMMAND */
            $this->commandHandler->__invoke(
                new RestoreUserTokenCommand(
                    RequestService::getField($request, 'email')
                )
            );

            return new JsonResponse([
                'status' => 'ok',
                'message' => "User token restored"
            ], 201);

        } catch (\Throwable $th) {
            return $this->errorHandler->handle($th);
        }
    }

}