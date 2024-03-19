<?php

namespace App\Api\Auth\Infrastructure\Controller;

use App\Api\Auth\Application\RegisterUser\RegisterUserCommand;
use App\Api\Auth\Application\RegisterUser\RegisterUserCommandHandler;
use App\Api\Auth\Infrastructure\Exception\AuthErrorHandler;
use App\Api\Shared\Infrastructure\Service\RequestService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class RegisterUserController extends AbstractController
{
    public function __construct(
        private readonly RegisterUserCommandHandler $commandHandler,
        private readonly AuthErrorHandler $errorHandler,
    )
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            /** RUN COMMAND */
            $this->commandHandler->__invoke(
                new RegisterUserCommand(
                    RequestService::getField($request, 'name'),
                    RequestService::getField($request, 'surname'),
                    RequestService::getField($request, 'gender'),
                    RequestService::getField($request, 'email'),
                    RequestService::getField($request, 'phone'),
                    RequestService::getField($request, 'residence'),
                    RequestService::getField($request, 'cp'),
                    RequestService::getField($request, 'country'),
                    RequestService::getField($request, 'city'),
                    RequestService::getField($request, 'password'),
                    RequestService::getField($request, 'birthdate')
                )
            );

            return new JsonResponse([
                'status' => 'ok',
                'message' => "User registered successfully"
            ], 201);

        } catch (\Throwable $th) {
            return $this->errorHandler->handle($th);
        }
    }

}