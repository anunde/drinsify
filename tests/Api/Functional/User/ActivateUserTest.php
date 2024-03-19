<?php

namespace App\Tests\Api\Functional\User;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ActivateUserTest extends WebTestCase
{

    /** @test
     * @throws \Exception
     */
    public function testActivateUser(): void
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/v1/users/activate',
            [], [], [],
            json_encode([
                'uid' => '0b99ab67-5c5e-4ffa-ae4a-8ed7f95f0f1b',
                'token' => '12345678'
            ])
        );

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertResponseHeaderSame('Content-Type', 'application/json');

        $response = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals('ok', $response['status']);
        $this->assertEquals('User activated!', $response['message']);
    }

    /** @test
     * @throws \Exception
     */
    public function userNotFound(): void
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/v1/users/activate',
            [], [], [],
            json_encode([
                'uid' => '0b99ab67',
                'token' => '123'
            ])
        );

        $this->assertEquals(Response::HTTP_NOT_FOUND, $client->getResponse()->getStatusCode());
        $this->assertResponseHeaderSame('Content-Type', 'application/json');

        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('code', $response);
        $this->assertEquals('nok', $response['status']);
        $this->assertEquals(\sprintf('User not found by id %s and token %s', '0b99ab67', '123'), $response['message']);
    }
}