<?php

namespace App\Api\Profile\Infrastructure\Controller;

use App\Api\Profile\Application\GetUserData\GetUserDataQuery;
use App\Api\Profile\Application\UpdateUserData\UpdateUserDataCommand;
use App\Api\Profile\Application\UpdateUserData\UpdateUserDataCommandHandler;
use App\Api\Profile\Infrastructure\Exception\ProfileErrorHandler;
use App\Api\Shared\Infrastructure\Service\RequestService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class UpdateUserDataController extends AbstractController
{
    public function __construct(
        private readonly UpdateUserDataCommandHandler $handler,
        private readonly ProfileErrorHandler     $errorHandler
    )
    {
    }

    #[Route(path: '/user/update/data', name: 'user_update', methods: "POST")]
    public function __invoke(Request $request, $userId): JsonResponse
    {
        try {
            $this->handler->__invoke(
                new UpdateUserDataCommand(
                    $userId,
                    RequestService::getField($request, 'name'),
                    RequestService::getField($request, 'email'),
                    RequestService::getField($request, 'phone'),
                    RequestService::getField($request, 'residence'),
                    RequestService::getField($request, 'businessName'),
                    RequestService::getField($request, 'cuit'),
                    RequestService::getField($request, 'metamaskAddress')
                ));

            return new JsonResponse([
                'status' => 'ok',
                'message' => 'Data updated!'
            ]);
        } catch (\Throwable $th) {
            return $this->errorHandler->handle($th);
        }
    }
}