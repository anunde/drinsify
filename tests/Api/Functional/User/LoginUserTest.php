<?php

namespace App\Tests\Api\Functional\User;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class LoginUserTest extends WebTestCase
{
    /** @test
     * @throws \Exception
     */
    public function testLoginUserSuccess()
    {
        $client = static::createClient();

        $requestData = [
            'email' => 'test@example.com',
            'password' => 'password'
        ];

        $client->request(
            'POST',
            '/api/v1/users/login',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($requestData)
        );

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        $responseData = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('token', $responseData);
    }

    /** @test
     * @throws \Exception
     */
    public function testLoginUserFailure()
    {
        $client = static::createClient();

        $requestData = [
            'email' => 'test@example.com',
            'password' => 'wrongpassword'
        ];

        $client->request(
            'POST',
            '/api/v1/users/login',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($requestData)
        );

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
        $responseData = json_decode($response->getContent(), true);
        $this->assertEquals('Invalid credentials', $responseData['message']);
    }

    /** @test
     * @throws \Exception
     */
    public function testLoginUserNotRegistered()
    {
        $client = static::createClient();

        $requestData = [
            'email' => 'nonexistent@example.com',
            'password' => 'password'
        ];

        $client->request(
            'POST',
            '/api/v1/users/login',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($requestData)
        );

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
        $responseData = json_decode($response->getContent(), true);
        $this->assertEquals('User not found by email nonexistent@example.com', $responseData['message']);
    }
}