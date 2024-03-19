<?php

namespace App\Api\Checkout\Infrastructure\Controller;

use App\Api\Checkout\Application\SubtractProductFromCart\SubtractProductFromCartCommand;
use App\Api\Checkout\Application\SubtractProductFromCart\SubtractProductFromCartCommandHandler;
use App\Api\Checkout\Infrastructure\Exception\CheckoutErrorHandler;
use App\Api\Shared\Infrastructure\Service\RequestService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class SubtractProductFromCartController extends AbstractController
{
    public function __construct(
        private readonly SubtractProductFromCartCommandHandler $handler,
        private readonly CheckoutErrorHandler $errorHandler
    )
    {
    }

    public function __invoke(Request $request, $userId): JsonResponse
    {
        try {
            $this->handler->__invoke(
                new SubtractProductFromCartCommand(
                    $userId,
                    RequestService::getField($request, 'productId')
                )
            );

            return new JsonResponse([
                'status' => 'ok',
                'message' => 'Product removed'
            ]);
        } catch (\Throwable $th) {
            return $this->errorHandler->handle($th);
        }
    }
}