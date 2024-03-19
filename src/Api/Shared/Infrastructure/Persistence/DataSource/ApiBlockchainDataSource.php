<?php

namespace App\Api\Shared\Infrastructure\Persistence\DataSource;

abstract class ApiBlockchainDataSource
{
    public function __construct(
        private readonly string $key_api_blockchain,
        private readonly string $url_api_blockchain
    )
    {
    }

    public function connection(array $data): array
    {
        $curl = \curl_init();
        $headers = [
            'Content-Type: application/json',
            'apiKey: ' . $this->key_api_blockchain
        ];

        if(isset($data['headers']))
        {
            foreach($data['headers'] as $key => $value)
            {
                $headers[] = $key . ': ' . $value;
            }
        }

        if(!isset($data['fields']))
        {
            $data['fields'] = [];
        }

        \curl_setopt_array($curl, array(
            CURLOPT_URL => $this->url_api_blockchain . $data['endpoint'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $data['method'],
            CURLOPT_POSTFIELDS => $data['fields'],
            CURLOPT_HTTPHEADER => $headers
        ));

        $response = \json_decode(\curl_exec($curl), true);
        $response_code = \curl_getinfo($curl, CURLINFO_HTTP_CODE);

        \curl_close($curl);

        return [
            'dump' => [
                'url' => $this->url_api_blockchain,
                'data' => $data
            ],
            'code' => $response_code,
            'response' => $response
        ];
    }
}