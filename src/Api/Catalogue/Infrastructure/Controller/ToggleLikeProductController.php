<?php

namespace App\Api\Catalogue\Infrastructure\Controller;

use App\Api\Catalogue\Application\ToogleLikeProduct\ToggleLikeProductCommand;
use App\Api\Catalogue\Application\ToogleLikeProduct\ToggleLikeProductCommandHandler;
use App\Api\Catalogue\Infrastructure\Exception\CatalogueErrorHandle;
use App\Api\Shared\Infrastructure\Service\RequestService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class ToggleLikeProductController extends AbstractController
{
    public function __construct(
        private readonly ToggleLikeProductCommandHandler $handler,
        private readonly CatalogueErrorHandle $errorHandle
    )
    {
    }

    public function __invoke(Request $request, $userId): JsonResponse
    {
        try {
            $this->handler->__invoke(
                new ToggleLikeProductCommand(
                    $userId,
                    RequestService::getField($request, 'productId')
                )
            );

            return new JsonResponse([
                'status' => 'ok',
                'message' => 'User likes list modified'
            ]);
        } catch (\Throwable $th) {
            return $this->errorHandle->handle($th);
        };
    }
}