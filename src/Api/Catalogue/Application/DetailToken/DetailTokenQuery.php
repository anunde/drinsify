<?php

namespace App\Api\Catalogue\Application\DetailToken;

final readonly class DetailTokenQuery
{
    public function __construct(
        private string $id,
        private string $iso,
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
}