<?php

namespace App\Api\Catalogue\Infrastructure\Controller;

use App\Api\Catalogue\Application\SearchTokensInSale\SearchTokensInSaleQuery;
use App\Api\Catalogue\Application\SearchTokensInSale\SearchTokensInSaleQueryHandler;
use App\Api\Catalogue\Infrastructure\Exception\CatalogueErrorHandle;
use App\Api\Catalogue\Infrastructure\Transformer\TokenItemListTransformer;
use App\Api\Shared\Domain\Service\GeolocationInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SearchTokensInSaleController extends AbstractController
{
    public function __construct(
        private readonly CatalogueErrorHandle $errorHandle,
        private readonly SearchTokensInSaleQueryHandler $handler,
        private readonly GeolocationInterface $geolocation,
        private readonly TokenItemListTransformer $transformer
    )
    {
    }

    #[Route(path: '/marketplace/tokens', name: 'marketplace_tokens', methods: "GET")]
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $connectionInfo = $this->geolocation->getInfoConnection();

            $tokens = $this->handler->__invoke(
                new SearchTokensInSaleQuery(
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

            return new JsonResponse($this->transformer->transform($tokens));
        } catch (\Throwable $th) {
            return $this->errorHandle->handle($th);
        }
    }
}