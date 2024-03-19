<?php

namespace App\Api\Auth\Infrastructure\Persistence\DataSource;
use App\Api\Auth\Domain\DataSource\UserApiDataSource as ApiDataSourceInterface;

class UserApiDataSourceTest implements ApiDataSourceInterface
{

    public function createUserAddress(): string
    {
        return '0x123';
    }
}