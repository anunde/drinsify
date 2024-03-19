<?php

namespace App\Api\Catalogue\Application\DetailProduct;

final readonly class DetailProductQuery
{
    public function __construct(
        private string $id,
        private string $iso,
        private string $currency,
        private string $symbol
    )
    {
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getIso(): string
    {
        return $this->iso;
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