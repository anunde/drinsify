<?php

namespace App\Api\Catalogue\Domain\Repository;

interface OriginRepositoryInterface
{
    public function findAll(): array;
}