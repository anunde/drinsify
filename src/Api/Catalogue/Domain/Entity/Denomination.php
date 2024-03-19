<?php

namespace App\Api\Catalogue\Domain\Entity;

use App\Shared\Domain\Entity;

final class Denomination extends Entity
{
    public function __construct(
        private readonly DenominationId $id,
        private DenominationName $name
    )
    {
    }

    public static function create(
        DenominationName $name
    ): self
    {
        return new self(
            new DenominationId(DenominationId::random()),
            new DenominationName($name)
        );
    }

    /**
     * @return DenominationId
     */
    public function getId(): DenominationId
    {
        return $this->id;
    }

    /**
     * @return DenominationName
     */
    public function getName(): DenominationName
    {
        return $this->name;
    }
}