<?php

namespace App\Api\Tokenization\Infrastructure\Controller;

use App\Api\Checkout\Application\SetOrderPaid\SetOrderPaidCommand;
use App\Api\Checkout\Application\SetOrderPaid\SetOrderPaidCommandHandler;
use App\Api\Tokenization\Application\TokenAddInfoFromMint\TokenAddInfoFromMintCommand;
use App\Api\Tokenization\Application\TokenAddInfoFromMint\TokenAddInfoFromMintCommandHandler;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class SetTokenInfoWebhookController extends AbstractController
{
    public function __construct(
        private TokenAddInfoFromMintCommandHandler $handler,
        private LoggerInterface $logger
    )
    {
    }

    #[Route(path: '/webhook/mint/token/{tokenId}', name: 'webhook_token_mint', methods: "POST")]
    public function __invoke($tokenId): JsonResponse
    {
        $payload = @file_get_contents('php://input');
        $this->logger->info('Received Token Mint Webhook', ['payload' => $payload]);
        $info = \json_decode($payload, true);
        $tokenNumber = $info['tokenId'];

        if ($tokenNumber) {
            try {
                $this->handler->__invoke(new TokenAddInfoFromMintCommand($tokenId, $tokenNumber));
            } catch (\Throwable $th) {
                $this->logger->error('Error processing info from token mint', [
                    'exception' => $th,
                    'token' => $tokenId
                ]);
            }

        }

        return new JsonResponse([], 200);
    }
}