<?php

namespace App\Shared\Infrastructure;

use App\Shared\Domain\UuidGenerator as UuidGeneratorInterface;
use Symfony\Component\Uid\Uuid;

final class UuidGenerator implements UuidGeneratorInterface
{
    public function generate(): string
    {
        return Uuid::v4();
    }
}