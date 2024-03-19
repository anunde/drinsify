<?php

namespace App\Api\Profile\Infrastructure\Transformer;

use App\Api\Shared\Domain\Transformer\TransformerInterface;

class ListUserTokensTransformer implements TransformerInterface
{
    public function transform($tokens): array
    {
        return array_map(function($tokenData) {
            $token = $tokenData['token'];

            return [
                'id'           => $token->getId()->value(),
                'tokenName'    => $token->getProduct()->getName(),
                'tokenNumber'  => $token->getTokenNumber(),
                'inSale'       => $token->isInSale(),
                'isRequested'  => $token->isRequested(),
                'price'        => $token->getPrice() ?? $token->getProduct()->getPrice(),
                'minRequestDate' => $token->getProduct()->getProductInfo()->getMinRequestDate()->format('Y-m-d H:i:s'),
                'cellarName'   => $tokenData['cellarName'],
            ];
        }, $tokens);
    }
}