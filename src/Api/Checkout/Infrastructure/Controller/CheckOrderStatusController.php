<?php

namespace App\Api\Checkout\Infrastructure\Controller;

use App\Api\Checkout\Application\CheckOrderStatus\CheckOrderStatusQuery;
use App\Api\Checkout\Application\CheckOrderStatus\CheckOrderStatusQueryHandler;
use App\Api\Checkout\Infrastructure\Exception\CheckoutErrorHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class CheckOrderStatusController extends AbstractController
{
    public function __construct(
        private readonly CheckoutErrorHandler $errorHandler,
        private readonly CheckOrderStatusQueryHandler $handler
    )
    {
    }

    #[Route(path: '/order/check/{internalReference}', name: 'order_check')]
    public function __invoke($userId, $internalReference): JsonResponse
    {
        try {
            $status = $this->handler->__invoke(
                new CheckOrderStatusQuery($userId, $internalReference)
            );

            return new JsonResponse([
                'status' => 'ok',
                'payment' => $status
            ]);
        } catch (\Throwable $th) {
            return $this->errorHandler->handle($th);
        }
    }
}