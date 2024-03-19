<?php

namespace App\Api\Catalogue\Domain\Read;

use App\Api\Shared\Domain\Entity\CellarName;
use App\Api\Shared\Domain\Entity\ProductId;
use App\Api\Shared\Domain\Entity\ProductName;
use App\Api\Shared\Domain\Entity\ProductPrice;
use App\Api\Shared\Domain\Entity\ProductQuantity;
use App\Api\Shared\Domain\Entity\ProductThumbnail;

final class ProductItemListDTO
{
    public function __construct(
        private readonly ProductId $id,
        private readonly ProductName $name,
        private readonly CellarName $cellarName,
        private readonly ProductThumbnail $thumbnail,
        private readonly ProductPrice $price,
        private readonly ProductQuantity $quantity,
        private ?string $localPrice
    )
    {
    }

    public static function create(
        string $id,
        string $name,
        string $cellarName,
        string $thumbnail,
        float $price,
        int $quantity
    ): self
    {
        return new self(
            new ProductId($id),
            new ProductName($name),
            new CellarName($cellarName),
            new ProductThumbnail($thumbnail),
            new ProductPrice($price),
            new ProductQuantity($quantity),
            null
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

    public function getQuantity(): int
    {
        return $this->quantity->value();
    }

    public function setLocalPrice(string $price, string $currencySymbol): void
    {
        $this->localPrice = $price . " ". $currencySymbol;
    }

    /**
     * @return string|null
     */
    public function getLocalPrice(): ?string
    {
        return $this->localPrice;
    }
}