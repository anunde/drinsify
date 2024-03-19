<?php

namespace App\Tests\Api\Functional\User;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ResetUserPasswordTest extends WebTestCase
{
    /** @test
     * @throws \Exception
     */
    public function resetUserPasswordTest(): void
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/v1/users/reset/password',
            [], [], [],
            json_encode([
                'uid' => '0b99ab67-5c5e-4ffa-ae4a-8ed7f95f0f1b',
                'token' => '123',
                'password' => 'newpassword'
            ])
        );

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertResponseHeaderSame('Content-Type', 'application/json');

        $response = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals('ok', $response['status']);
        $this->assertEquals('Password changed successfully!', $response['message']);
    }

    /** @test
     * @throws \Exception
     */
    public function userNotFound(): void
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/v1/users/reset/password',
            [], [], [],
            json_encode([
                'uid' => '0b99ab67',
                'token' => '1',
                'password' => 'newpassword'
            ])
        );

        $this->assertEquals(Response::HTTP_NOT_FOUND, $client->getResponse()->getStatusCode());
        $this->assertResponseHeaderSame('Content-Type', 'application/json');

        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('code', $response);
        $this->assertEquals('nok', $response['status']);
        $this->assertEquals(\sprintf('User not found by id %s and reset password token %s', '0b99ab67', '1'), $response['message']);
    }

    /** @test
     * @throws \Exception
     */
    public function invalidPassword(): void
    {
        $client = static::createClient();

        $requestData = [
            'uid' => '0b99ab67-5c5e-4ffa-ae4a-8ed7f95f0f1b',
            'token' => '123',
            'password' => 'test'
        ];

        $client->request('POST', '/api/v1/users/reset/password', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($requestData));

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $client->getResponse()->getStatusCode());

        $responseContent = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('code', $responseContent);
        $this->assertEquals('The password must contain at least 8 characters', $responseContent['message']);
    }
}