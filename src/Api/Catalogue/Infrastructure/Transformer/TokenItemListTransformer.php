<?php

namespace App\Api\Catalogue\Infrastructure\Transformer;

use App\Api\Shared\Domain\Transformer\TransformerInterface;

class TokenItemListTransformer implements TransformerInterface
{
    public function transform($tokens): array
    {
        $result = [];
        foreach ($tokens as $token) {
            $result[] = [
                'id' => $token->getId(),
                'name' => $token->getName(),
                'cellarName' => $token->getCellarName(),
                'thumbnail' => $token->getThumbnail(),
                'price' => $token->getPrice() . ' USDC',
            ];
        }

        return $result;
    }
}