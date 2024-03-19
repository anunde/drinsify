<?php

namespace App\Api\Checkout\Infrastructure\Controller;

use App\Api\Checkout\Application\AddProductToCart\AddProductToCartCommand;
use App\Api\Checkout\Application\AddProductToCart\AddProductToCartCommandHandler;
use App\Api\Checkout\Infrastructure\Exception\CheckoutErrorHandler;
use App\Api\Shared\Infrastructure\Service\RequestService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class AddProductToCartController extends AbstractController
{
    public function __construct(
        private readonly AddProductToCartCommandHandler $handler,
        private readonly CheckoutErrorHandler $errorHandler
    )
    {
    }

    public function __invoke(Request $request, $userId): JsonResponse
    {
        try {
            $this->handler->__invoke(
              new AddProductToCartCommand(
                  $userId,
                  RequestService::getField($request, 'productId')
              )
            );

            return  new JsonResponse([
               'status' => 'ok',
               'message' => 'Product Added'
            ]);
        } catch(\Throwable $th) {
            return $this->errorHandler->handle($th);
        }
    }
}