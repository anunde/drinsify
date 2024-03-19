<?php

namespace App\Api\Auth\Infrastructure\Service;

use App\Api\Auth\Domain\Service\JWTEncoderInterface as JWTEncoderDomain;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTEncodeFailureException;

readonly class JWTEncoder implements JWTEncoderDomain
{
    public function __construct(
        private JWTEncoderInterface $jwtEncoder
    )
    {
    }

    /**
     * @throws JWTEncodeFailureException
     */
    public function encode(array $data): string
    {
        return $this->jwtEncoder->encode($data);
    }
}