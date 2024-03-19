<?php

namespace App\Api\Catalogue\Infrastructure\Transformer;

use App\Api\Shared\Domain\Transformer\TransformerInterface;

final class ProductDetailTransformer implements TransformerInterface
{

    public function transform($product): array
    {
        return [
            'name' => $product->getName(),
            'description' => $product->getDescription(),
            'price' => $product->getPrice(),
            'features' => \json_decode($product->getFeatures(), true),
            'image' => $product->getImage(),
            'dataSheet' => $product->getDataSheet(),
            'awards' => $product->getAwards(),
            'existenceProof' => $product->getExistenceProof(),
            'cellarName' => $product->getCellarName(),
            'localPrice' => $product->getLocalPrice()
        ];
    }
}