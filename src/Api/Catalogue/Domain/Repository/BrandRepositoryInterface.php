<?php

namespace App\Api\Catalogue\Domain\Repository;

interface BrandRepositoryInterface
{
    public function findAll(): array;
}