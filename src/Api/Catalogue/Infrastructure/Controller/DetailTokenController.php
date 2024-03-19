<?php

namespace App\Api\Catalogue\Infrastructure\Controller;

use App\Api\Catalogue\Application\DetailProduct\DetailProductQuery;
use App\Api\Catalogue\Application\DetailToken\DetailTokenQuery;
use App\Api\Catalogue\Application\DetailToken\DetailTokenQueryHandler;
use App\Api\Catalogue\Infrastructure\Exception\CatalogueErrorHandle;
use App\Api\Catalogue\Infrastructure\Transformer\TokenDetailTransformer;
use App\Api\Shared\Domain\Service\GeolocationInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class DetailTokenController extends AbstractController
{
    public function __construct(
        private readonly GeolocationInterface    $geolocation,
        private readonly CatalogueErrorHandle    $errorHandle,
        private readonly DetailTokenQueryHandler $handler,
        private readonly TokenDetailTransformer $transformer
    )
    {
    }

    #[Route(path: '/token/detail/{id}', name: 'detail_token', methods: "GET")]
    public function __invoke($id): JsonResponse
    {
        try {
            $connectionInfo = $this->geolocation->getInfoConnection();

            $token = $this->handler->__invoke(
                new DetailTokenQuery(
                    $id,
                    $connectionInfo['iso']
                )
            );

            return new JsonResponse($this->transformer->transform($token));
        } catch (\Throwable $th) {
            return $this->errorHandle->handle($th);
        }
    }
}