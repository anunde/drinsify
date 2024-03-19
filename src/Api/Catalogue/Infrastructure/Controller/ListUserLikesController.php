<?php

namespace App\Api\Catalogue\Infrastructure\Controller;

use App\Api\Catalogue\Application\ListUserLikes\ListUserLikesQuery;
use App\Api\Catalogue\Application\ListUserLikes\ListUserLikesQueryHandler;
use App\Api\Catalogue\Infrastructure\Exception\CatalogueErrorHandle;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

final  class ListUserLikesController extends AbstractController
{
    public function __construct(
        private readonly ListUserLikesQueryHandler $handler,
        private readonly CatalogueErrorHandle $errorHandle
    )
    {
    }

    public function __invoke($userId): JsonResponse
    {
        try {
            $result = $this->handler->__invoke(
                new ListUserLikesQuery(
                    $userId
                )
            );

            return new JsonResponse($result);
        } catch (\Throwable $th) {
            return $this->errorHandle->handle($th);
        }
    }
}