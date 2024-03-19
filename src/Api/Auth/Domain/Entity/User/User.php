<?php

namespace App\Api\Auth\Domain\Entity\User;

use App\Api\Shared\Domain\Entity\UserId;
use App\Shared\Domain\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
final class User extends Entity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="user_id", unique=true)
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private UserId $id;

    /**
     * @ORM\Column(type="string")
     */
    private string $name;

    /**
     * @ORM\Column(type="string")
     */
    private string $surname;

    /**
     * @ORM\Column(type="string")
     */
    private string $gender;

    /**
     * @ORM\Column(type="string")
     */
    private string $email;

    /**
     * @ORM\Column(type="integer")
     */
    private int $phone;

    /**
     * @ORM\Column(type="string")
     */
    private string $residence;

    /**
     * @ORM\Column(type="string")
     */
    private string $cp;

    /**
     * @ORM\Column(type="string")
     */
    private string $country;

    /**
     * @ORM\Column(type="string")
     */
    private string $city;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $token = null;

    /**
     * @ORM\Column(type="string")
     */
    private string $password;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTime $birthdate;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $businessName = null;


    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $cuit = null;


    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $metamaskAddress = null;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $activated;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $address = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $resetPasswordToken = null;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTime $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTime $updatedAt;

    public function __construct(
        UserId $id,
        UserName $name,
        UserSurname $surname,
        UserGender $gender,
        UserEmail $email,
        UserPhone $phone,
        UserResidence $residence,
        UserCp $cp,
        UserCountry $country,
        UserCity $city,
        ?UserToken $token,
        UserPassword $password,
        UserBirthdate $birthdate,
        ?UserBusinessName $businessName,
        ?UserCuit $cuit,
        ?UserMetamaskAddress $metamaskAddress,
        UserActivated $activated,
        ?UserAddress $address,
        ?UserResetPasswordToken $resetPasswordToken,
        UserCreatedAt $createdAt,
        UserUpdatedAt $updatedAt
    )
    {

        $this->id = $id;
        $this->name = $name->value();
        $this->surname = $surname->value();
        $this->gender = $gender->value();
        $this->email = $email->value();
        $this->phone = $phone->value();
        $this->residence = $residence->value();
        $this->cp = $cp->value();
        $this->country = $country->value();
        $this->city = $city->value();
        $this->token = $token?->value();
        $this->password = $password->value();
        $this->birthdate = $birthdate->value();
        $this->businessName = $businessName?->value();
        $this->cuit = $cuit?->value();
        $this->metamaskAddress = $metamaskAddress?->value();
        $this->activated = $activated->value();
        $this->address = $address?->value();
        $this->resetPasswordToken = $resetPasswordToken?->value();
        $this->createdAt = $createdAt->value();
        $this->updatedAt = $updatedAt->value();
    }

    /**
     * @throws \Exception
     */
    public static function create(
        $name,
        $surname,
        $gender,
        $email,
        $phone,
        $residence,
        $cp,
        $country,
        $city,
        $password,
        $birthdate
    ): self
    {
        return new self(
            new UserId(UserId::random()),
            new UserName($name),
            new UserSurname($surname),
            new UserGender($gender),
            new UserEmail($email),
            new UserPhone($phone),
            new UserResidence($residence),
            new UserCp($cp),
            new UserCountry($country),
            new UserCity($city),
            new UserToken(\sha1(\uniqid())),
            new UserPassword($password),
            new UserBirthdate(new \DateTime($birthdate)),
            null,
            null,
            null,
            new UserActivated(false),
            null,
            null,
            new UserCreatedAt(new \DateTime()),
            new UserUpdatedAt(new \DateTime())
        );
    }

    /**
     * @throws \Exception
     */
    public static function fromPrimitives(array $data): User
    {
        return new self(
            new UserId($data['id']),
            new UserName($data['name']),
            new UserSurname($data['surname']),
            new UserGender($data['gender']),
            new UserEmail($data['email']),
            isset($data['token']) ? new UserToken($data['token']) : null,
            new UserPassword($data['password']),
            new UserBirthdate(new \DateTime($data['birthdate'])),
            new UserActivated($data['activated']),
            isset($data['address']) ? new UserAddress($data['address']) : null,
            isset($data['reset_password_token']) ? new UserResetPasswordToken($data['reset_password_token']) : null,
            new UserCreatedAt(new \DateTime($data['created_at'])),
            new UserUpdatedAt(new \DateTime($data['updated_at']))
        );
    }

    /**
     * @return UserId
     */
    public function getId(): UserId
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
    public function getSurname(): string
    {
        return $this->surname;
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
     * @return string|null
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return \DateTime
     */
    public function getBirthdate(): \DateTime
    {
        return $this->birthdate;
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

    /**
     * @return bool
     */
    public function getActivated(): bool
    {
        return $this->activated;
    }

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @return string|null
     */
    public function getResetPasswordToken(): ?string
    {
        return $this->resetPasswordToken;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function updateTimestamps(): void
    {
        $this->updatedAt = new \DateTime();
    }

    public function activateUser(): void
    {
        $this->activated = true;
        $this->token = null;
    }

    public function assignNetworkAddress(string $address): void
    {
        $this->address = $address;
    }

    public function generateToken(): void
    {
        $this->token = \sha1(\uniqid());
    }

    public function generateResetPasswordToken(): void
    {
        $this->resetPasswordToken = \sha1(\uniqid());
    }

    public function isActivated(): bool
    {
        return $this->activated->value();
    }

    public function resetPassword(string $password): void
    {
        $this->password = $password;
        $this->resetPasswordToken = null;
    }

    public function updateData(
        UserName $name,
        UserEmail $email,
        UserPhone $phone,
        UserResidence $residence,
        ?UserBusinessName $businessName,
        ?UserCuit $cuit,
        ?UserMetamaskAddress $metamaskAddress
    ): void
    {
        $this->name = $name->value();
        $this->email = $email->value();
        $this->phone = $phone->value();
        $this->residence = $residence->value();
        $this->businessName = $businessName?->value();
        $this->cuit = $cuit?->value();
        $this->metamaskAddress = $metamaskAddress?->value();
    }
}