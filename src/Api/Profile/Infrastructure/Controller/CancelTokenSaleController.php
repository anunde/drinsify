<?php

namespace App\Api\Profile\Infrastructure\Controller;

use App\Api\Profile\Application\CancelTokenSale\CancelTokenSaleCommand;
use App\Api\Profile\Application\CancelTokenSale\CancelTokenSaleCommandHandler;
use App\Api\Profile\Application\PutTokenInSale\PutTokenInSaleCommand;
use App\Api\Profile\Application\PutTokenInSale\PutTokenInSaleCommandHandler;
use App\Api\Profile\Infrastructure\Exception\ProfileErrorHandler;
use App\Api\Shared\Infrastructure\Service\RequestService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class CancelTokenSaleController extends AbstractController
{
    public function __construct(
        private readonly CancelTokenSaleCommandHandler $handler,
        private readonly ProfileErrorHandler $errorHandler
    )
    {
    }

    #[Route(path: '/user/cancel/token/{tokenId}', name: 'user_cancel_token')]
    public function __invoke(Request $request, $tokenId, $userId): JsonResponse
    {
        try {
            $this->handler->__invoke(
                new CancelTokenSaleCommand(
                    $userId,
                    $tokenId
                )
            );

            return new JsonResponse([
                'status' => 'ok',
                'message' => 'Token sale cancelled'
            ]);
        } catch (\Throwable $th) {
            return $this->errorHandler->handle($th);
        }
    }

}