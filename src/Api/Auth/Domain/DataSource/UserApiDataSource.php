<?php

namespace App\Api\Auth\Domain\DataSource;

interface UserApiDataSource
{
    public function createUserAddress(): string;
}