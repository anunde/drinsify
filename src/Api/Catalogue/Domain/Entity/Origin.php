<?php

namespace App\Api\Catalogue\Domain\Entity;

use App\Shared\Domain\Entity;

final class Origin extends Entity
{
    public function __construct(
        private readonly OriginId $id,
        private OriginName $name
    )
    {
    }

    public static function create(
        OriginName $name
    ):self
    {
        return new self(
            new OriginId(OriginId::random()),
            new OriginName($name)
        );
    }

    /**
     * @return OriginId
     */
    public function getId(): OriginId
    {
        return $this->id;
    }

    /**
     * @return OriginName
     */
    public function getName(): OriginName
    {
        return $this->name;
    }
}