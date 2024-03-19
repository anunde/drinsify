<?php

namespace App\Api\Auth\Application\RegisterUser;

use phpDocumentor\Reflection\Types\Integer;

final readonly class RegisterUserCommand
{
    public function __construct(
        private string $name,
        private string $surname,
        private string $gender,
        private string $email,
        private int $phone,
        private string $residence,
        private string $cp,
        private string $country,
        private string $city,
        private string $password,
        private string $birthdate
    )
    {
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
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return int
     */
    public function getPhone(): int
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
     * @return string
     */
    public function getCp(): string
    {
        return $this->cp;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getGender(): string
    {
        return $this->gender;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getBirthdate(): string
    {
        return $this->birthdate;
    }
}