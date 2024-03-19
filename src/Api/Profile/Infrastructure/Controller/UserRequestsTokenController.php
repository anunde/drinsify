<?php

namespace App\Api\Profile\Infrastructure\Controller;

use App\Api\Profile\Application\GetUserData\GetUserDataQuery;
use App\Api\Profile\Application\GetUserData\GetUserDataQueryHandler;
use App\Api\Profile\Application\UserRequestsNft\UserRequestsTokenCommand;
use App\Api\Profile\Application\UserRequestsNft\UserRequestsTokenCommandHandler;
use App\Api\Profile\Infrastructure\Exception\ProfileErrorHandler;
use App\Api\Profile\Infrastructure\Mailing\SubjectMapping;
use App\Api\Profile\Infrastructure\Mailing\TemplateMapping;
use App\Api\Profile\Infrastructure\Transformer\GetUserDataTransformer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class UserRequestsTokenController extends AbstractController
{
    public function __construct(
        private readonly string $project_email,
        private readonly UserRequestsTokenCommandHandler $handler,
        private readonly ProfileErrorHandler     $errorHandler
    )
    {
    }

    #[Route(path: '/user/request/token/{tokenId}', name: 'user_request_token')]
    public function __invoke($userId, $tokenId): JsonResponse
    {
        try {
            $this->handler->__invoke(
                new UserRequestsTokenCommand(
                    $userId,
                    $tokenId,
                    $this->project_email,
                    SubjectMapping::SUBJECT_MAPPING['user_requests_token'],
                    TemplateMapping::TEMPLATE_MAPPING['user_requests_token'],
                )
            );

            return new JsonResponse([
                'status' => 'ok',
                'message' => 'Token requested successfully!'
            ]);
        } catch (\Throwable $th) {
            return $this->errorHandler->handle($th);
        }
    }
}