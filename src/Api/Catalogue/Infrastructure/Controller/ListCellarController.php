<?php

namespace App\Api\Catalogue\Infrastructure\Controller;

use App\Api\Catalogue\Application\ListCellar\ListCellarQueryHandler;
use App\Api\Catalogue\Infrastructure\Exception\CatalogueErrorHandle;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

final class ListCellarController extends AbstractController
{
    public function __construct(
        private readonly ListCellarQueryHandler $handler,
        private readonly CatalogueErrorHandle $errorHandle
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