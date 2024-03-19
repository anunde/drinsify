<?php

namespace App\Api\Shared\Infrastructure\Persistence\DataSource;

class InMemoryDataSource
{
    public static array $data = [
        'Api' => [
            'users' => [
                '1' => [
                    'id' => '0b99ab67-5c5e-4ffa-ae4a-8ed7f95f0f1b',
                    'name' => 'Álvaro',
                    'surname' => 'Núñez',
                    'activated' => '0',
                    'address' => null,
                    'email' => 'alvaro@example.com',
                    'gender' => 'male',
                    'password' => 'password',
                    'token' => '123',
                    'birthdate' => '2000-06-06',
                    'reset_password_token' => '123',
                    'updated_at' => '2023-06-06 00:00:00',
                    'created_at' => '2023-06-06 00:00:00'
                ],
                '2' => [
                    'id' => '0b99ab67-5c5e-4ffa-ae4a-8ed7f95f0f1b',
                    'name' => 'Activated',
                    'surname' => 'User',
                    'activated' => '1',
                    'address' => '0x123',
                    'email' => 'activated@example.com',
                    'gender' => 'male',
                    'birthdate' => '2000-06-06',
                    'password' => 'password',
                    'token' => null,
                    'reset_password_token' => '123',
                    'updated_at' => '2023-06-06 00:00:00',
                    'created_at' => '2023-06-06 00:00:00'
                ],
                '3' => [
                    'id' => '0b99ab67-5c5e-4ffa-ae4a-8ed7f95f0f1b',
                    'name' => 'User',
                    'surname' => 'Test',
                    'activated' => '0',
                    'address' => '0x123',
                    'email' => 'test@example.com',
                    'gender' => 'male',
                    'birthdate' => '2000-06-06',
                    'password' => 'password',
                    'token' => '12345678',
                    'reset_password_token' => '123',
                    'updated_at' => '2023-06-06 00:00:00',
                    'created_at' => '2023-06-06 00:00:00'
                ],
                '4' => [
                    'id' => '629736e0-facd-4412-a067-5c5781f06339',
                    'name' => 'Like',
                    'surname' => 'Test',
                    'activated' => '1',
                    'address' => '0x123',
                    'email' => 'like@example.com',
                    'gender' => 'male',
                    'birthdate' => '2000-06-06',
                    'password' => 'password',
                    'token' => null,
                    'reset_password_token' => null,
                    'updated_at' => '2023-06-06 00:00:00',
                    'created_at' => '2023-06-06 00:00:00'
                ]
            ],
            'products' => [
                '1' => [
                    'id' => '3105d970-b304-4f1f-91be-d763922afaa4',
                    'origin_id' => 'ab85db5c-c124-424b-80c9-dea9c2cb1573',
                    'denomination_id' => 'd8506636-02a9-4f4a-a326-da5349a1ffd3',
                    'brand_id' => '51e8ae49-114c-4017-a0af-f34663f93e28',
                    'cellar_id' => 'f771b165-d722-470b-a363-727ad72f0555',
                    'name' => 'Mauricio Lorca Ancestral',
                    'description' => 'Description',
                    'image' => 'https://drinksify.s3.eu-west-1.amazonaws.com/items/finalancestral-63eb8b59ecc11.webm',
                    'type' => 'video',
                    'quantity' => 3,
                    'extension' => 'webm',
                    'status' => 1,
                    'price' => 155,
                    'countries_available' => 'ES',
                    'created_at' => '2023-06-06 00:00:00',
                ]
            ],
            'likes' => [
                '1' => [
                    'id' => 'a5776b11-2858-49a3-ad88-6277a95d047b',
                    'user_id' => '629736e0-facd-4412-a067-5c5781f06339',
                    'product_id' => '3105d970-b304-4f1f-91be-d763922afaa4'
                ]
            ]
        ]
    ];
}