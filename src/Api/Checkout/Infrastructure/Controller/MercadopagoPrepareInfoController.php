<?php

namespace App\Api\Checkout\Infrastructure\Controller;

use App\Api\Checkout\Application\CancelOrder\CancelOrderCommand;
use App\Api\Checkout\Application\CancelOrder\CancelOrderCommandHandler;
use App\Api\Checkout\Application\GenerateMercadopagoPreferenceId\GenerateMercadopagoPreferenceIdQuery;
use App\Api\Checkout\Application\GenerateMercadopagoPreferenceId\GenerateMercadopagoPreferenceIdQueryHandler;
use App\Api\Checkout\Application\GenerateOrderFromCart\GenerateOrderFromCartCommand;
use App\Api\Checkout\Application\GenerateOrderFromCart\GenerateOrderFromCartCommandHandler;
use App\Api\Checkout\Infrastructure\Exception\CheckoutErrorHandler;
use App\Api\Shared\Infrastructure\Client\EndpointMapping;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

final class MercadopagoPrepareInfoController extends AbstractController
{
    public function __construct(
        private readonly string $host,
        private readonly string $mercadopago_access_token,
        private readonly GenerateMercadopagoPreferenceIdQueryHandler $handler,
        private readonly GenerateOrderFromCartCommandHandler $orderHandler,
        private readonly CancelOrderCommandHandler $cancelOrderCommandHandler,
        private readonly CheckoutErrorHandler                $errorHandler
    )
    {
    }

    public function __invoke($userId): JsonResponse
    {
        try {
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
                    'mercadopago'
                )
            );

            //Generate preferenceId
            $preferenceId = $this->handler->__invoke(
                new GenerateMercadopagoPreferenceIdQuery(
                    $userId,
                    $internalReference,
                    $this->mercadopago_access_token,
                    $this->host,
                    EndpointMapping::ENDPOINT_MAPPING['waiting_payment'],
                    EndpointMapping::ENDPOINT_MAPPING['failed_payment']
                )
            );

            return new JsonResponse($preferenceId);
        } catch (\Throwable $th) {
            return $this->errorHandler->handle($th);
        }
    }
}