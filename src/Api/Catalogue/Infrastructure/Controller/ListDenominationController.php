<?php

namespace App\Api\Catalogue\Infrastructure\Controller;

use App\Api\Catalogue\Application\ListDenomination\ListDenominationQueryHandler;
use App\Api\Catalogue\Infrastructure\Exception\CatalogueErrorHandle;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

final class ListDenominationController extends AbstractController
{
    public function __construct(
        private readonly CatalogueErrorHandle $errorHandle,
        private readonly ListDenominationQueryHandler $handler
    )
    {
    }

    public function __invoke(): JsonResponse
    {
        try {
            return new JsonResponse($this->handler->__invoke());
        } catch (\Throwable $th) {
            return $this->errorHandle->handle($th);
        }
    }
}