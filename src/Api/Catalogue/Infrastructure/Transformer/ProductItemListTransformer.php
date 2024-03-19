<?php

namespace App\Api\Catalogue\Infrastructure\Transformer;

use App\Api\Shared\Domain\Transformer\TransformerInterface;

class ProductItemListTransformer implements TransformerInterface
{

    public function transform($products): array
    {
        $result = [];
        foreach ($products as $product) {
            $result[] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'cellarName' => $product->getCellarName(),
                'thumbnail' => $product->getThumbnail(),
                'price' => $product->getLocalPrice(),
                'quantity' => $product->getQuantity()
            ];
        }

        return $result;
    }
}