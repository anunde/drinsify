<?php

namespace App\Api\Shared\Domain\Transformer;

interface TransformerInterface
{
    public function transform($item): array;
}