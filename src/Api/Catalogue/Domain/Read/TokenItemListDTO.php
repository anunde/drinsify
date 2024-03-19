<?php

namespace App\Api\Catalogue\Domain\Read;

use App\Api\Shared\Domain\Entity\CellarName;
use App\Api\Shared\Domain\Entity\ProductId;
use App\Api\Shared\Domain\Entity\ProductName;
use App\Api\Shared\Domain\Entity\ProductPrice;
use App\Api\Shared\Domain\Entity\ProductQuantity;
use App\Api\Shared\Domain\Entity\ProductThumbnail;

final readonly class TokenItemListDTO
{
    public function __construct(
        private ProductId        $id,
        private ProductName      $name,
        private CellarName       $cellarName,
        private ProductThumbnail $thumbnail,
        private ProductPrice     $price,
    )
    {
    }

    public static function create(
        string $id,
        string $name,
        string $cellarName,
        string $thumbnail,
        float $price,
    ): self
    {
        return new self(
            new ProductId($id),
            new ProductName($name),
            new CellarName($cellarName),
            new ProductThumbnail($thumbnail),
            new ProductPrice($price),
        );
    }

    public function getId(): string
    {
        return $this->id->value();
    }


    public function getName(): string
    {
        return $this->name->value();
    }

    public function getCellarName(): string
    {
        return $this->cellarName->value();
    }

    public function getThumbnail(): string
    {
        return $this->thumbnail->value();
    }


    public function getPrice(): float
    {
        return $this->price->value();
    }
}