<?php

namespace App\Api\Shared\Infrastructure\Persistence\DataSource;

use App\Api\Shared\Domain\DataSource\CoinbaseApiDataSourceInterface;

class CoinbaseApiDataSource implements CoinbaseApiDataSourceInterface
{

    public function getCurrencyRate(string $rate): float
    {
        $response = json_decode($this->init('https://api.coinbase.com/v2/exchange-rates?currency=USDC'));

        $rates = (array)$response->data->rates;
        if (!array_key_exists($rate, $rates)) {
            throw new \RuntimeException('That rate is not available');
        }

        return $rates[$rate];
    }

    private function init(string $url, $header = [], string $method = 'GET', $data = []): string
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        if ($header) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }
        curl_setopt($ch, CURLOPT_HEADER, false);

        if ($method != 'GET') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $output = curl_exec($ch);
        if (!$output) {
            $output = curl_error($ch);
        }
        $info = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($info != 200 && $info != 201) {
            throw new \Exception($output.'/'.json_encode($data), 1);
        }

        return $output;
    }
}