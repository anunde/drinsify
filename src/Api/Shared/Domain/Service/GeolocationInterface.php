<?php

namespace App\Api\Shared\Domain\Service;

interface GeolocationInterface
{
    public function getInfoConnection(): array;
}