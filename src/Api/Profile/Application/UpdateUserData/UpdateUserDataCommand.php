<?php

namespace App\Api\Profile\Application\UpdateUserData;

final readonly class UpdateUserDataCommand
{
    public function __construct(
        private string $id,
        private string $name,
        private string $email,
        private string $phone,
        private string $residence,
        private ?string $businessName,
        private ?string $cuit,
        private ?string $metamaskAddress
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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @return string
     */
    public function getResidence(): string
    {
        return $this->residence;
    }

    /**
     * @return string|null
     */
    public function getBusinessName(): ?string
    {
        return $this->businessName;
    }

    /**
     * @return string|null
     */
    public function getCuit(): ?string
    {
        return $this->cuit;
    }

    /**
     * @return string|null
     */
    public function getMetamaskAddress(): ?string
    {
        return $this->metamaskAddress;
    }
}