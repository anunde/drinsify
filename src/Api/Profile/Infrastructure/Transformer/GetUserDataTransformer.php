<?php

namespace App\Api\Profile\Infrastructure\Transformer;

use App\Api\Shared\Domain\Transformer\TransformerInterface;

class GetUserDataTransformer implements TransformerInterface
{

    public function transform($user): array
    {
        return [
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'phone' => $user->getPhone(),
            'residence' => $user->getResidence(),
            'businessName' => $user->getBusinessName(),
            'cuit' => $user->getCuit(),
            'metamaskAddress' => $user->getMetamaskAddress()
        ];
    }
}