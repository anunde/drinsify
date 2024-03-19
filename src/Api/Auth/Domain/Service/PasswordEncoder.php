<?php

namespace App\Api\Auth\Domain\Service;

interface PasswordEncoder
{
    public function encode(string $plainPassword): string;

    public function isValid(string $plainPassword, string $hashedPassword): bool;
}