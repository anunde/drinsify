<?php

namespace App\Api\Auth\Infrastructure\Service;
use \App\Api\Auth\Domain\Service\PasswordEncoder as PasswordEncoderInterface;
final class PasswordEncoder implements PasswordEncoderInterface
{
    private const MIN_LENGTH = 8;

    public function encode(string $plainPassword): string
    {
        if(self::MIN_LENGTH > \strlen($plainPassword)) {
            throw new \InvalidArgumentException('The password must contain at least 8 characters');
        }

        $hash = password_hash($plainPassword, PASSWORD_DEFAULT);

        if (!$hash) {
            throw new \RuntimeException('Password hashing failed');
        }

        return $hash;
    }

    public function isValid(string $plainPassword, string $hashedPassword): bool
    {
        return password_verify($plainPassword, $hashedPassword);
    }
}