<?php

namespace App\Api\Profile\Infrastructure\Controller;

use App\Api\Profile\Application\ListUserTokens\ListUserTokensQuery;
use App\Api\Profile\Application\ListUserTokens\ListUserTokensQueryHandler;
use App\Api\Profile\Infrastructure\Exception\ProfileErrorHandler;
use App\Api\Profile\Infrastructure\Transformer\ListUserTokensTransformer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class ListUserTokensController extends AbstractController
{
    public function __construct(
        private readonly ListUserTokensQueryHandler $handler,
        private readonly ProfileErrorHandler $errorHandler,
        private readonly ListUserTokensTransformer $transformer
    )
    {
    }

    #[Route(path: '/user/tokens', name: 'user_tokens')]
    public function __invoke($userId): JsonResponse
    {
        try {
            $tokens = $this->handler->__invoke(
                new ListUserTokensQuery($userId)
            );

            $tokens = $this->transformer->transform($tokens);

            return new JsonResponse($tokens);
        } catch (\Throwable $th) {
            return $this->errorHandler->handle($th);
        }
    }
}