<?php

namespace App\Api\Auth\Infrastructure\Service;

final class PasswordEncoderTest implements \App\Api\Auth\Domain\Service\PasswordEncoder
{
    private const MIN_LENGTH = 8;
    public function encode(string $plainPassword): string
    {
        if(self::MIN_LENGTH > \strlen($plainPassword)) {
            throw new \InvalidArgumentException('The password must contain at least 8 characters');
        }

        return $plainPassword;
    }

    public function isValid(string $plainPassword, string $hashedPassword): bool
    {
        if ($plainPassword != $hashedPassword) {
            return false;
        }

        return true;
    }
}