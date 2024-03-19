<?php

namespace App\Api\Checkout\Infrastructure\Controller;

use App\Api\Checkout\Application\GetCartTotalAmount\GetCartTotalAmountQuery;
use App\Api\Checkout\Application\GetCartTotalAmount\GetCartTotalAmountQueryHandler;
use App\Api\Checkout\Infrastructure\Exception\CheckoutErrorHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

final class MetamaskPrepareInfoController extends AbstractController
{
    public function __construct(
        private readonly string $project_address,
        private readonly GetCartTotalAmountQueryHandler $handler,
        private readonly CheckoutErrorHandler $errorHandler
    )
    {
    }

    public function __invoke($userId): JsonResponse
    {
        try {
            $amount = $this->handler->__invoke(new GetCartTotalAmountQuery($userId));

            return new JsonResponse([
               'amount' => $amount,
               'address' => $this->project_address
            ]);
        } catch (\Throwable $th) {
            return $this->errorHandler->handle($th);
        }
    }
}