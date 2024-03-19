<?php

namespace App\Tests\Api\Functional\User;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class RestoreUserTokenTest extends WebTestCase
{
    /** @test
     * @throws \Exception
     */
    public function testRestoreUserToken(): void
    {
        $client = static::createClient();
        $client->request('POST', '/api/v1/users/restore/token', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode(['email' => 'test@example.com']));

        $this->assertEquals(Response::HTTP_CREATED, $client->getResponse()->getStatusCode());
        $responseContent = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals('ok', $responseContent['status']);
        $this->assertEquals('User token restored', $responseContent['message']);
    }

    /** @test
     * @throws \Exception
     */
    public function notRegisteredEmail(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/v1/users/restore/token', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode(['email' => 'nonexistent@example.com']));

        $this->assertEquals(Response::HTTP_NOT_FOUND, $client->getResponse()->getStatusCode());
        $responseContent = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('code', $responseContent);
        $this->assertEquals('User not found by email nonexistent@example.com', $responseContent['message']);
    }

    /** @test
     * @throws \Exception
     */
    public function alreadyActivated(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/v1/users/restore/token', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode(['email' => 'activated@example.com']));

        $this->assertEquals(Response::HTTP_CONFLICT, $client->getResponse()->getStatusCode());
        $responseContent = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('code', $responseContent);
        $this->assertEquals('The email activated@example.com is already activated', $responseContent['message']);
    }
}