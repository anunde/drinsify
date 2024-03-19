<?php

namespace App\Api\Checkout\Infrastructure\Controller;

use App\Api\Checkout\Application\UserEmptyCart\UserEmptyCartCommand;
use App\Api\Checkout\Application\UserEmptyCart\UserEmptyCartCommandHandler;
use App\Api\Checkout\Infrastructure\Exception\CheckoutErrorHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

final class UserEmptyCartController extends AbstractController
{
    public function __construct(
        private readonly UserEmptyCartCommandHandler $handler,
        private readonly CheckoutErrorHandler        $errorHandler
    )
    {
    }

    public function __invoke($userId): JsonResponse
    {
        try {

            $this->handler->__invoke(new UserEmptyCartCommand($userId));

            return new JsonResponse([
               'status' => 'ok',
               'message' => 'Cart cleared!'
            ]);

        } catch (\Throwable $th) {
            return $this->errorHandler->handle($th);
        }
    }
}