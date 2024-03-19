<?php

namespace App\Api\Catalogue\Infrastructure\Controller;

use App\Api\Catalogue\Application\DetailProduct\DetailProductQuery;
use App\Api\Catalogue\Application\DetailProduct\DetailProductQueryHandler;
use App\Api\Catalogue\Infrastructure\Exception\CatalogueErrorHandle;
use App\Api\Catalogue\Infrastructure\Transformer\ProductDetailTransformer;
use App\Api\Shared\Domain\Service\GeolocationInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

final class DetailProductController extends AbstractController
{
     public function __construct(
         private readonly DetailProductQueryHandler $handler,
         private readonly CatalogueErrorHandle $errorHandle,
         private readonly ProductDetailTransformer $transformer,
         private readonly GeolocationInterface $geolocation
     )
     {
     }

     public function __invoke($id): JsonResponse
     {
         try {
             $connectionInfo = $this->geolocation->getInfoConnection();

             $product = $this->handler->__invoke(
                 new DetailProductQuery(
                     $id,
                     $connectionInfo['iso'],
                     $connectionInfo['currency'],
                     $connectionInfo['symbol']
                 )
             );

             return new JsonResponse($this->transformer->transform($product));
         } catch (\Throwable $th) {
             return $this->errorHandle->handle($th);
         }
     }
}