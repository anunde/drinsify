<?php

namespace App\Api\Catalogue\Application\SearchTokensInSale;

final readonly class SearchTokensInSaleQuery
{
    public function __construct(
        private ?string $cellarId,
        private ?string $originId,
        private ?string $brandId,
        private ?string $denominationId,
        private ?float $minPrice,
        private ?float $maxPrice,
        private ?int $limit,
        private string $isoCode,
        private string $currency,
        private string $symbol
    )
    {
    }

    /**
     * @return string|null
     */
    public function getCellarId(): ?string
    {
        return $this->cellarId;
    }

    /**
     * @return string|null
     */
    public function getOriginId(): ?string
    {
        return $this->originId;
    }

    /**
     * @return string|null
     */
    public function getBrandId(): ?string
    {
        return $this->brandId;
    }

    /**
     * @return string|null
     */
    public function getDenominationId(): ?string
    {
        return $this->denominationId;
    }

    /**
     * @return float|null
     */
    public function getMinPrice(): ?float
    {
        return $this->minPrice;
    }

    /**
     * @return float|null
     */
    public function getMaxPrice(): ?float
    {
        return $this->maxPrice;
    }

    /**
     * @return int|null
     */
    public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
     * @return string
     */
    public function getIsoCode(): string
    {
        return $this->isoCode;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @return string
     */
    public function getSymbol(): string
    {
        return $this->symbol;
    }
}