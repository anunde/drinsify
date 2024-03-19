<?php

namespace App\Api\Catalogue\Domain\Read;

use App\Api\Catalogue\Domain\Entity\ProductInfoAwards;
use App\Api\Catalogue\Domain\Entity\ProductInfoDataSheet;
use App\Api\Catalogue\Domain\Entity\ProductInfoExistenceProof;
use App\Api\Catalogue\Domain\Entity\ProductInfoFeatures;
use App\Api\Catalogue\Domain\Entity\ProductInfoImage;
use App\Api\Shared\Domain\Entity\CellarName;
use App\Api\Shared\Domain\Entity\ProductDescription;
use App\Api\Shared\Domain\Entity\ProductName;
use App\Api\Shared\Domain\Entity\ProductPrice;

final readonly class TokenDetailDTO
{
    public function __construct(
        private ProductName               $name,
        private CellarName                $cellarName,
        private ProductDescription        $description,
        private ProductPrice              $price,
        private ProductInfoFeatures       $features,
        private ProductInfoImage          $image,
        private ProductInfoDataSheet      $dataSheet,
        private ProductInfoAwards         $awards,
        private ProductInfoExistenceProof $existenceProof,
    )
    {
    }

    public static function create(
        string $name,
        string $cellarName,
        string $description,
        float $price,
        string $features,
        string $image,
        string $dataSheet,
        string $awards,
        string $existenceProof
    ): self {
        return new self(
            new ProductName($name),
            new CellarName($cellarName),
            new ProductDescription($description),
            new ProductPrice($price),
            new ProductInfoFeatures($features),
            new ProductInfoImage($image),
            new ProductInfoDataSheet($dataSheet),
            new ProductInfoAwards($awards),
            new ProductInfoExistenceProof($existenceProof),
        );
    }

    public function getName(): string
    {
        return $this->name->value();
    }

    public function getCellarName(): string
    {
        return $this->cellarName->value();
    }

    public function getDescription(): string
    {
        return $this->description->value();
    }

    public function getPrice(): float
    {
        return $this->price->value();
    }

    public function getFeatures(): string
    {
        return $this->features->value();
    }

    public function getImage(): string
    {
        return $this->image->value();
    }

    public function getDataSheet(): string
    {
        return $this->dataSheet->value();
    }

    public function getAwards(): string
    {
        return $this->awards->value();
    }

    public function getExistenceProof(): string
    {
        return $this->existenceProof->value();
    }
}