<?php

namespace App\Tests\Api\Functional\Catalogue;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class DetailProductTest extends WebTestCase
{
    /** @test
     * @throws \Exception
     */
    public function detailProductTest(): void
    {
        $client = static::createClient();

        $client->request(
            'GET',
            'api/v1/product/detail/3105d970-b304-4f1f-91be-d763922afaa4'
        );

        $response = $client->getResponse();

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertJson($response->getContent());
    }

    /** @test
     * @throws \Exception
     */
    public function productNotFound(): void
    {
        $client = static::createClient();

        $id = '3105d970';
        $client->request(
            'GET',
            'api/v1/product/detail/3105d970'
        );

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
        $responseData = \json_decode($response->getContent(), true);
        $this->assertArrayHasKey('code', $responseData);
        $this->assertEquals(\sprintf('Product with id %s, not found', $id), $responseData['message']);
    }
}