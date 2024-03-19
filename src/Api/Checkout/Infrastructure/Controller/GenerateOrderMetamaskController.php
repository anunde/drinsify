<?php

namespace App\Api\Checkout\Infrastructure\Controller;

use App\Api\Checkout\Application\AddExternalReferenceToOrder\AddExternalReferenceToOrderCommand;
use App\Api\Checkout\Application\AddExternalReferenceToOrder\AddExternalReferenceToOrderCommandHandler;
use App\Api\Checkout\Application\CancelOrder\CancelOrderCommand;
use App\Api\Checkout\Application\CancelOrder\CancelOrderCommandHandler;
use App\Api\Checkout\Application\GenerateOrderFromCart\GenerateOrderFromCartCommand;
use App\Api\Checkout\Application\GenerateOrderFromCart\GenerateOrderFromCartCommandHandler;
use App\Api\Checkout\Infrastructure\Exception\CheckoutErrorHandler;
use App\Api\Shared\Infrastructure\Service\RequestService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class GenerateOrderMetamaskController extends AbstractController
{
    public function __construct(
        private readonly CheckoutErrorHandler $errorHandler,
        private readonly CancelOrderCommandHandler $cancelOrderCommandHandler,
        private readonly GenerateOrderFromCartCommandHandler $orderHandler,
        private readonly AddExternalReferenceToOrderCommandHandler $handler
    )
    {
    }

    #[Route(path: '/generate/metamask/order', name: 'generate_metamask_order', methods: "POST")]
    public function __invoke($userId, Request $request): JsonResponse
    {
        try {
            $externalReference = RequestService::getField($request, 'externalReference');

            //Cancel previous opened order
            $this->cancelOrderCommandHandler->__invoke(
                new CancelOrderCommand(
                    $userId
                )
            );

            //Generate Order
            $internalReference = $this->orderHandler->__invoke(
                new GenerateOrderFromCartCommand(
                    $userId,
                    'metamask'
                )
            );

            $this->handler->__invoke(
                new AddExternalReferenceToOrderCommand(
                    $internalReference,
                    $externalReference
                )
            );

            return new JsonResponse([
                'status' => 'ok',
                'internalReference' => $internalReference
            ]);
        } catch (\Throwable $th) {
            return $this->errorHandler->handle($th);
        }
    }
}