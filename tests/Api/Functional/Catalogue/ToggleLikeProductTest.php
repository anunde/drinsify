<?php

namespace App\Tests\Api\Functional\Catalogue;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ToggleLikeProductTest extends WebTestCase
{
    /** @test
     * @throws \Exception
     */
    public function addLikeProductTest() {
        $client = static::createClient();
        $productId = '3105d970-b304-4f1f-91be-d763922afaa4';

        $jwtEncoder = static::$container->get('app.test.jwt_encoder');
        $token = $jwtEncoder->encode([
            'username' => 'test@example.com',
            'exp' => time() + 60
        ]);

        $client->request(
            'POST',
            "/api/v1/product/like/toggle",
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_AUTHORIZATION' => 'Bearer '.$token
            ],
            json_encode(['productId' => $productId])
        );

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        $responseContent = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('status', $responseContent);
        $this->assertEquals('User likes list modified', $responseContent['message']);
    }

    /** @test
     * @throws \Exception
     */
    public function removeLikeProductTest() {
        $client = static::createClient();
        $productId = '3105d970-b304-4f1f-91be-d763922afaa4';

        $jwtEncoder = static::$container->get('app.test.jwt_encoder');
        $token = $jwtEncoder->encode([
            'username' => 'like@example.com',
            'exp' => time() + 60
        ]);

        $client->request(
            'POST',
            "/api/v1/product/like/toggle",
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_AUTHORIZATION' => 'Bearer '.$token
            ],
            json_encode(['productId' => $productId])
        );

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        $responseContent = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('status', $responseContent);
        $this->assertEquals('User likes list modified', $responseContent['message']);
    }

    /** @test
     * @throws \Exception
     */
    public function productNotExists() {
        $client = static::createClient();
        $productId = '3105d970-b304-4f1f-91be-d763922afbb4';

        $jwtEncoder = static::$container->get('app.test.jwt_encoder');
        $token = $jwtEncoder->encode([
            'username' => 'like@example.com',
            'exp' => time() + 60
        ]);

        $client->request(
            'POST',
            "/api/v1/product/like/toggle",
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_AUTHORIZATION' => 'Bearer '.$token
            ],
            json_encode(['productId' => $productId])
        );

        $this->assertEquals(Response::HTTP_NOT_FOUND, $client->getResponse()->getStatusCode());

        $responseContent = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('code', $responseContent);
        $this->assertEquals(\sprintf('Product with id %s, not found', $productId), $responseContent['message']);
    }
}