<?php

namespace App\Tests\Api\Functional\Catalogue;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SearchProductsTest extends WebTestCase
{
    /** @test
     * @throws \Exception
     */
    public function testSearchProducts()
    {
        $client = static::createClient();

        $parameters = [
            'cellarId' => 'f771b165-d722-470b-a363-727ad72f0555',
            'originId' => 'ab85db5c-c124-424b-80c9-dea9c2cb1573',
            'brandId' => '51e8ae49-114c-4017-a0af-f34663f93e28',
            'denominationId' => 'd8506636-02a9-4f4a-a326-da5349a1ffd3',
            'minPrice' => 100,
            'maxPrice' => 500,
        ];

        $client->request(
            'GET',
            '/api/v1/marketplace',
            [], [], [],
            \json_encode($parameters)
        );

        $response = $client->getResponse();

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertJson($response->getContent());
    }
}