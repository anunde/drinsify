<?php

namespace App\Api\Contact\Infrastructure\Controller;

use App\Api\Contact\Application\UserSendMessage\UserSendMessageCommand;
use App\Api\Contact\Application\UserSendMessage\UserSendMessageCommandHandler;
use App\Api\Contact\Infrastructure\Exception\ContactErrorHandler;
use App\Api\Shared\Infrastructure\Service\RequestService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class UserSendMessageController extends AbstractController
{
    public function __construct(
        private readonly UserSendMessageCommandHandler $handler,
        private readonly ContactErrorHandler $errorHandler
    )
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $this->handler->__invoke(
                new UserSendMessageCommand(
                    RequestService::getField($request, 'email'),
                    RequestService::getField($request, 'message')
                )
            );

            return new JsonResponse([
                'status' => 'ok',
                'message' => 'Message sent!'
            ]);
        } catch (\Throwable $th) {
            dd($th);
            return $this->errorHandler->handle($th);
        }
    }
}