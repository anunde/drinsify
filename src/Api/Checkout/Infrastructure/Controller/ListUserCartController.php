<?php

namespace App\Api\Checkout\Infrastructure\Controller;

use App\Api\Checkout\Application\ListUserCart\ListUserCartQuery;
use App\Api\Checkout\Application\ListUserCart\ListUserCartQueryHandler;
use App\Api\Checkout\Infrastructure\Exception\CheckoutErrorHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

final class ListUserCartController extends AbstractController
{
    public function __construct(
        private readonly ListUserCartQueryHandler $handler,
        private readonly CheckoutErrorHandler     $errorHandler
    )
    {
    }

    public function __invoke($userId): JsonResponse
    {
        try {
            $result = $this->handler->__invoke(
                new ListUserCartQuery($userId)
            );

            return new JsonResponse($result);
        } catch (\Throwable $th) {
            return $this->errorHandler->handle($th);
        }
    }
}