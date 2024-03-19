<?php

namespace App\Api\Catalogue\Domain\Repository;

interface DenominationRepositoryInterface
{
    public function findAll(): array;
}