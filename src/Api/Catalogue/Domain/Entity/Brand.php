<?php

namespace App\Api\Catalogue\Domain\Entity;

use App\Shared\Domain\Entity;

final class Brand extends Entity
{
    public function __construct(
        private readonly BrandId $id,
        private BrandName $name
    )
    {
    }

    public static function create(
        BrandName $name
    ):self
    {
        return new self(
            new BrandId(BrandId::random()),
            new BrandName($name)
        );
    }

    /**
     * @return BrandId
     */
    public function getId(): BrandId
    {
        return $this->id;
    }

    /**
     * @return BrandName
     */
    public function getName(): BrandName
    {
        return $this->name;
    }
}