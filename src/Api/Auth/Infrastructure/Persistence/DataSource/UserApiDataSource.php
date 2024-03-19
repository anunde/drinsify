<?php

namespace App\Api\Auth\Infrastructure\Persistence\DataSource;

use App\Api\Shared\Domain\Exception\ApiResponseException;
use App\Api\Shared\Infrastructure\Persistence\DataSource\ApiBlockchainDataSource;
use App\Api\Auth\Domain\DataSource\UserApiDataSource as ApiDataSourceInterface;

class UserApiDataSource extends ApiBlockchainDataSource implements ApiDataSourceInterface
{
    private const ENDPOINTS_MAP = [
        'create_address' => '/api/users/'
    ];

    /**
     * @throws ApiResponseException
     */
    public function createUserAddress(): string
    {
        $data = [
            'endpoint' => self::ENDPOINTS_MAP['create_address'],
            'method' => 'POST',
            'fields' => \json_encode([
                "network" => 'ethereum',
                "addressMode" => "public",
                "isAdmin" => "0",
                "isFunded" => "1"
            ])
        ];

        $response = $this->connection($data);

        if(!201 === $response['code']) {
            throw new ApiResponseException('Api Response Error: Could not generate address');
        }

        return $response['response']['data']['address'];
    }
}