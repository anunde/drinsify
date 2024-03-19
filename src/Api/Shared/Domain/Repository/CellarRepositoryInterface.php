<?php

namespace App\Api\Shared\Domain\Repository;

use App\Api\Shared\Domain\Entity\Cellar;

interface CellarRepositoryInterface
{
    public function save(Cellar $cellar): void;

    public function findAll(): array;
}