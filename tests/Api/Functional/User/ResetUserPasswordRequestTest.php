<?php

namespace App\Tests\Api\Functional\User;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ResetUserPasswordRequestTest extends WebTestCase
{
    /** @test
     * @throws \Exception
     */
    public function restoreUserPasswordTest(): void
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/v1/users/request/reset/password',
            [], [], [],
            json_encode([
                'email' => 'test@example.com',
            ])
        );

        $this->assertEquals(Response::HTTP_CREATED, $client->getResponse()->getStatusCode());
        $this->assertResponseHeaderSame('Content-Type', 'application/json');

        $response = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals('ok', $response['status']);
        $this->assertEquals('Generated User reset password token', $response['message']);
    }

    /** @test
     * @throws \Exception
     */
    public function userNotFound(): void
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/v1/users/request/reset/password',
            [], [], [],
            json_encode([
                'email' => 'test-not-exists@example.com',
            ])
        );

        $this->assertEquals(Response::HTTP_NOT_FOUND, $client->getResponse()->getStatusCode());
        $this->assertResponseHeaderSame('Content-Type', 'application/json');

        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('code', $response);
        $this->assertEquals('nok', $response['status']);
        $this->assertEquals(\sprintf('User not found by email %s', 'test-not-exists@example.com'), $response['message']);
    }
}