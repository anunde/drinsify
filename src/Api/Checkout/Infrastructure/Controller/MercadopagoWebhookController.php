<?php

namespace App\Api\Checkout\Infrastructure\Controller;

use App\Api\Checkout\Application\SetOrderPaid\SetOrderPaidCommand;
use App\Api\Checkout\Application\SetOrderPaid\SetOrderPaidCommandHandler;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class MercadopagoWebhookController extends AbstractController
{
    public function __construct(
        private readonly string $mercadopago_access_token,
        private readonly SetOrderPaidCommandHandler $handler,
        private readonly LoggerInterface $logger
    )
    {
    }

    #[Route(path: '/webhook/mercadopago', name: 'webhook_mercadopago', methods: "POST")]
    public function __invoke(): JsonResponse
    {
        $payload = @file_get_contents('php://input');
        $this->logger->info('Received MercadoPago webhook', ['payload' => $payload]);

        $info = \json_decode($payload, true);
        $id = $info['data']['id'];

        $payment = $this->checkMercadoPagoAccepted($id);

        if ('approved' === $payment['status'] && !empty($payment['date_approved'])) {
            try {
                $mercadopagoReference = $payment['external_reference'];
                $this->handler->__invoke(new SetOrderPaidCommand($mercadopagoReference, $id));
            } catch (\Throwable $th) {
                $this->logger->error('Error processing MercadoPago webhook', [
                    'exception' => $th,
                    'order' => $mercadopagoReference,
                    'paymentId' => $id
                ]);
            }

        }

        return new JsonResponse([], 200);
    }

    private function checkMercadoPagoAccepted($id): array
    {
        $MERCADOPAGO_PRIVATE_KEY = $this->mercadopago_access_token;
        $ch = \curl_init();

        \curl_setopt($ch, CURLOPT_URL, 'https://api.mercadopago.com/v1/payments/'.$id);
        \curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        \curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


        $headers = array();
        $headers[] = 'Authorization: Bearer '. $MERCADOPAGO_PRIVATE_KEY;
        \curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = \curl_exec($ch);
        if (\curl_errno($ch)) {
            echo 'Error:' . \curl_error($ch);
        }

        \curl_close($ch);

        return \json_decode($result, true);
    }
}