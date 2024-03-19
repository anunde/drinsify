<?php

namespace App\Api\Panel\Application\CreateProduct;

final readonly class CreateProductCommand
{
    public function __construct(
        private string $originId,
        private string $denominationId,
        private string $brandId,
        private string $cellarId,
        private string $name,
        private string $description,
        private string $thumbnail,
        private string $quantity,
        private string $status,
        private string $price,
        private array $taxes,
        private string $countriesAvailable,
        private array $features,
        private string $image,
        private string $dataSheet,
        private string $awards,
        private string $existenceProof,
        private string $daysDelivery,
        private string $qr,
        private string $requestDate
    )
    {
    }

    /**
     * @return string
     */
    public function getOriginId(): string
    {
        return $this->originId;
    }

    /**
     * @return string
     */
    public function getDenominationId(): string
    {
        return $this->denominationId;
    }

    /**
     * @return string
     */
    public function getBrandId(): string
    {
        return $this->brandId;
    }

    /**
     * @return string
     */
    public function getCellarId(): string
    {
        return $this->cellarId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getThumbnail(): string
    {
        return $this->thumbnail;
    }

    /**
     * @return string
     */
    public function getQuantity(): string
    {
        return $this->quantity;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getPrice(): string
    {
        return $this->price;
    }

    /**
     * @return array
     */
    public function getTaxes(): array
    {
        return $this->taxes;
    }

    /**
     * @return string
     */
    public function getCountriesAvailable(): string
    {
        return $this->countriesAvailable;
    }

    /**
     * @return array
     */
    public function getFeatures(): array
    {
        return $this->features;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @return string
     */
    public function getDataSheet(): string
    {
        return $this->dataSheet;
    }

    /**
     * @return string
     */
    public function getAwards(): string
    {
        return $this->awards;
    }

    /**
     * @return string
     */
    public function getExistenceProof(): string
    {
        return $this->existenceProof;
    }

    /**
     * @return string
     */
    public function getDaysDelivery(): string
    {
        return $this->daysDelivery;
    }

    /**
     * @return string
     */
    public function getQr(): string
    {
        return $this->qr;
    }

    /**
     * @return string
     */
    public function getRequestDate(): string
    {
        return $this->requestDate;
    }
}