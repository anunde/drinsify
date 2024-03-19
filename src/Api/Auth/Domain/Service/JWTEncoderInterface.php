<?php

namespace App\Api\Auth\Domain\Service;

interface JWTEncoderInterface
{
    public function encode(array $data): string;
}