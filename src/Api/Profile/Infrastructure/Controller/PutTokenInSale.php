<?php

namespace App\Api\Profile\Infrastructure\Controller;

use App\Api\Profile\Application\PutTokenInSale\PutTokenInSaleCommand;
use App\Api\Profile\Application\PutTokenInSale\PutTokenInSaleCommandHandler;
use App\Api\Profile\Infrastructure\Exception\ProfileErrorHandler;
use App\Api\Shared\Infrastructure\Service\RequestService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class PutTokenInSale extends AbstractController
{
    public function __construct(
        private readonly PutTokenInSaleCommandHandler $handler,
        private readonly ProfileErrorHandler $errorHandler
    )
    {
    }

    #[Route(path: '/user/sale/token/{tokenId}', name: 'user_sale_token')]
    public function __invoke(Request $request, $tokenId, $userId): JsonResponse
    {
        try {
            $this->handler->__invoke(
                new PutTokenInSaleCommand(
                    $userId,
                    $tokenId,
                    RequestService::getField($request, 'price')
                )
            );

            return new JsonResponse([
                'status' => 'ok',
                'message' => 'Token successfully put up for sale'
            ]);
        } catch (\Throwable $th) {
            return $this->errorHandler->handle($th);
        }
    }

}