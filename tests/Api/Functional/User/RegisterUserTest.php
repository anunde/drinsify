<?php

namespace App\Tests\Api\Functional\User;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class RegisterUserTest extends WebTestCase
{
    /** @test
     * @throws \Exception
     */
    public function testRegisterUser()
    {
        $client = static::createClient();

        $requestData = [
            'name' => 'Test',
            'surname' => 'User',
            'gender' => 'male',
            'email' => 'test-register@example.com',
            'password' => 'securepassword',
            'birthdate' => '1990-01-01'
        ];

        $client->request('POST', '/api/v1/users/register', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($requestData));

        $this->assertEquals(Response::HTTP_CREATED, $client->getResponse()->getStatusCode());

        $responseContent = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('status', $responseContent);
        $this->assertEquals('ok', $responseContent['status']);
        $this->assertArrayHasKey('message', $responseContent);
        $this->assertEquals('User registered successfully', $responseContent['message']);
    }

    /** @test
     * @throws \Exception
     */
    public function minorUser(): void
    {
        $client = static::createClient();

        $requestData = [
            'name' => 'Test',
            'surname' => 'User',
            'gender' => 'male',
            'email' => 'test-register@example.com',
            'password' => 'securepassword',
            'birthdate' => '2010-01-01'
        ];

        $client->request('POST', '/api/v1/users/register', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($requestData));

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $client->getResponse()->getStatusCode());

        $responseContent = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('code', $responseContent);
        $this->assertEquals('You have to be older than 18 years old to register in the platform', $responseContent['message']);
    }

    /** @test
     * @throws \Exception
     */
    public function invalidEmail(): void
    {
        $client = static::createClient();

        $requestData = [
            'name' => 'Test',
            'surname' => 'User',
            'gender' => 'male',
            'email' => 'invalid-email',
            'password' => 'securepassword',
            'birthdate' => '1980-01-01'
        ];

        $client->request('POST', '/api/v1/users/register', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($requestData));

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $client->getResponse()->getStatusCode());

        $responseContent = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('code', $responseContent);
        $this->assertEquals('The email invalid-email is invalid.', $responseContent['message']);
    }

    /** @test
     * @throws \Exception
     */
    public function emailAlreadyExists(): void
    {
        $client = static::createClient();

        $requestData = [
            'name' => 'Test',
            'surname' => 'User',
            'gender' => 'male',
            'email' => 'test@example.com',
            'password' => 'securepassword',
            'birthdate' => '1980-01-01'
        ];

        $client->request('POST', '/api/v1/users/register', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($requestData));

        $this->assertEquals(Response::HTTP_CONFLICT, $client->getResponse()->getStatusCode());

        $responseContent = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('code', $responseContent);
        $this->assertEquals('The user with email test@example.com already exists!', $responseContent['message']);
    }

    /** @test
     * @throws \Exception
     */
    public function invalidPassword(): void
    {
        $client = static::createClient();

        $requestData = [
            'name' => 'Test',
            'surname' => 'User',
            'gender' => 'male',
            'email' => 'test-register@example.com',
            'password' => '123',
            'birthdate' => '1980-01-01'
        ];

        $client->request('POST', '/api/v1/users/register', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($requestData));

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $client->getResponse()->getStatusCode());

        $responseContent = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('code', $responseContent);
        $this->assertEquals('The password must contain at least 8 characters', $responseContent['message']);
    }

    /** @test
     * @throws \Exception
     */
    public function missingParameters(): void
    {
        $client = static::createClient();

        $requestData = [
            // Nota: no estamos incluyendo el campo 'email'
            'name' => 'Test',
            'surname' => 'User',
            'gender' => 'male',
            'password' => '12345678',
            'birthdate' => '1980-01-01'
        ];

        $client->request('POST', '/api/v1/users/register', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($requestData));

        $this->assertEquals(Response::HTTP_NOT_FOUND, $client->getResponse()->getStatusCode());

        $responseContent = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('code', $responseContent);
        $this->assertEquals('Missing field email', $responseContent['message']);
    }
}