<?php

namespace App\Api\Profile\Infrastructure\Controller;

use App\Api\Profile\Application\GetUserData\GetUserDataQuery;
use App\Api\Profile\Application\GetUserData\GetUserDataQueryHandler;
use App\Api\Profile\Infrastructure\Exception\ProfileErrorHandler;
use App\Api\Profile\Infrastructure\Transformer\GetUserDataTransformer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class GetUserDataController extends AbstractController
{
    public function __construct(
        private readonly GetUserDataQueryHandler $handler,
        private readonly ProfileErrorHandler     $errorHandler,
        private readonly GetUserDataTransformer $transformer
    )
    {
    }

    #[Route(path: '/user/data', name: 'user_data')]
    public function __invoke($userId): JsonResponse
    {
        try {
            $user = $this->handler->__invoke(new GetUserDataQuery($userId));

            return new JsonResponse($this->transformer->transform($user));
        } catch (\Throwable $th) {
            return $this->errorHandler->handle($th);
        }
    }
}