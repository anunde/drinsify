<?php

namespace App\Api\Tokenization\Infrastructure\Persistence\DataSource;

use App\Api\Shared\Domain\Exception\ApiResponseException;
use App\Api\Shared\Infrastructure\Persistence\DataSource\ApiBlockchainDataSource;
use App\Api\Tokenization\Domain\DataSource\TokenApiDataSource as TokenApiDataSourceInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

class TokenApiDataSource extends ApiBlockchainDataSource implements TokenApiDataSourceInterface
{
    private const ENDPOINTS_MAP = [
        'create_token' => '/api/token/mint',
        'get_token_uri' => '/api/token/URI/'
    ];

    private RouterInterface $router;

    public function __construct(string $key_api_blockchain, string $url_api_blockchain, RouterInterface $router)
    {
        parent::__construct($key_api_blockchain, $url_api_blockchain);
        $this->router = $router;
    }

    /**
     * @param string $userAddress
     * @param string $tokenId
     * @return array
     * @throws ApiResponseException
     */
    public function createToken(string $userAddress, string $tokenId): string
    {
        //$webhookUrl = $this->router->generate('webhook_token_mint', ['tokenId' => $tokenId], UrlGeneratorInterface::ABSOLUTE_URL);
        $data = [
            'endpoint' => self::ENDPOINTS_MAP['create_token'],
            'method' => 'POST',
            'fields' => \json_encode([
                "to" => $userAddress,
                "hostname" => 'https://drinksify-api.test.back.oaro.net',
                "path" => '/api/v1/webhook/mint/token/' . $tokenId,
                "sim" => 0
            ])
        ];

        $response = $this->connection($data);

        if ($response['code'] !== 200 && $response['code'] !== 201) {
            throw new ApiResponseException('Api Response Error: Could not generate token');
        }

        return $response['response']['result'];
    }

    /**
     * @throws ApiResponseException
     */
    public function getTokenUri(string $tokenId): string
    {
        $data = [
            'endpoint' => self::ENDPOINTS_MAP['get_token_uri'] . $tokenId,
            'method' => 'GET'
        ];

        $response = $this->connection($data);

        if (!\in_array($response['code'], [200, 201]) && \is_null($response['response'])) {
            throw new ApiResponseException('Api Response Error: Could not get Token Uri');
        }

        return $response['response']['result'];
    }
}