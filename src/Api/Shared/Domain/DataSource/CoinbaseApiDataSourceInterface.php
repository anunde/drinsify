<?php

namespace App\Api\Shared\Domain\DataSource;

interface CoinbaseApiDataSourceInterface
{
    public function getCurrencyRate(string $iso): float;
}