<?php

namespace App\Api\Shared\Domain\Repository;

use App\Api\Catalogue\Domain\Read\TokenDetailDTO;
use App\Api\Shared\Domain\Entity\Token;

interface TokenRepositoryInterface
{
    public function save(Token $token): void;

    public function findByUser(string $userId): array;

    public function findById(string $id): ?Token;

    public function findReadById(string $id): ?TokenDetailDTO;

    public function findAllWithFilters(
        ?string $cellarId,
        ?string $originId,
        ?string $brandId,
        ?string $denominationId,
        ?float $minPrice,
        ?float $maxPrice,
        ?int $limit
    ): array;
}