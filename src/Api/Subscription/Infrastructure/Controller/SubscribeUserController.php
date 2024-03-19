<?php

namespace App\Api\Subscription\Infrastructure\Controller;

use App\Api\Shared\Infrastructure\Service\RequestService;
use App\Api\Subscription\Application\SubscribeUser\SubscribeUserCommand;
use App\Api\Subscription\Application\SubscribeUser\SubscribeUserCommandHandler;
use App\Api\Subscription\Infrastructure\Exception\SubscriptionErrorHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SubscribeUserController extends AbstractController
{
    public function __construct(
        private readonly SubscribeUserCommandHandler $handler,
        private readonly SubscriptionErrorHandler    $errorHandler
    )
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $this->handler->__invoke(
                new SubscribeUserCommand(
                    RequestService::getField($request, 'email')
                )
            );

            return new JsonResponse([
                'status' => 'ok',
                'message' => 'Successfully subscribed!'
            ]);
        } catch (\Throwable $th) {
            return $this->errorHandler->handle($th);
        }
    }
}