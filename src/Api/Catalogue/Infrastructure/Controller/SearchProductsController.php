<?php

namespace App\Api\Catalogue\Infrastructure\Controller;

use App\Api\Catalogue\Application\SearchProducts\SearchProductsQuery;
use App\Api\Catalogue\Application\SearchProducts\SearchProductsQueryHandler;
use App\Api\Catalogue\Infrastructure\Exception\CatalogueErrorHandle;
use App\Api\Catalogue\Infrastructure\Transformer\ProductItemListTransformer;
use App\Api\Shared\Domain\Service\GeolocationInterface;
use App\Api\Shared\Infrastructure\Service\RequestService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class SearchProductsController extends AbstractController
{
    public function __construct(
        private readonly CatalogueErrorHandle $errorHandle,
        private readonly SearchProductsQueryHandler $handler,
        private readonly GeolocationInterface $geolocation,
        private readonly ProductItemListTransformer $transformer
    )
    {
    }

    public function __invoke(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        try {
            $connectionInfo = $this->geolocation->getInfoConnection();

            $products = $this->handler->__invoke(
                new SearchProductsQuery(
                    $request->get('cellarId'),
                    $request->get('originId'),
                    $request->get('brandId'),
                    $request->get('denominationId'),
                    $request->get('minPrice'),
                    $request->get('maxPrice'),
                    $request->get('limit'),
                    $connectionInfo['iso'],
                    $connectionInfo['currency'],
                    $connectionInfo['symbol'],
                )
            );

            return new JsonResponse($this->transformer->transform($products));
        } catch (\Throwable $th) {
            return $this->errorHandle->handle($th);
        }
    }
}