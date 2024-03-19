<?php

namespace App\Api\Catalogue\Infrastructure\Transformer;

use App\Api\Shared\Domain\Transformer\TransformerInterface;

class TokenDetailTransformer implements TransformerInterface
{
    public function transform($token): array
    {
        return [
            'name' => $token->getName(),
            'description' => $token->getDescription(),
            'price' => $token->getPrice(),
            'features' => \json_decode($token->getFeatures(), true),
            'image' => $token->getImage(),
            'dataSheet' => $token->getDataSheet(),
            'awards' => $token->getAwards(),
            'existenceProof' => $token->getExistenceProof(),
            'cellarName' => $token->getCellarName()
        ];
    }
}