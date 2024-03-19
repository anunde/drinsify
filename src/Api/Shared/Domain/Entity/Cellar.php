<?php

namespace App\Api\Shared\Domain\Entity;

use App\Shared\Domain\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Date;

/**
 * @ORM\Entity
 * @ORM\Table(name="cellar")
 */
final class Cellar extends Entity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="cellar_id", unique=true)
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private CellarId $id;

    /**
     * @ORM\Column(type="string")
     */
    private string $name;

    /**
     * @ORM\Column(type="string")
     */
    private string $url;

    /**
     * @ORM\Column(type="string")
     */
    private string $image;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTime $createdAt;

    public function __construct(
        CellarId $id,
        CellarName $name,
        CellarUrl $url,
        CellarImage $image,
        CellarCreatedAt $createdAt
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->url = $url;
        $this->image = $image;
        $this->createdAt = $createdAt;
    }

    public static function create(
        $name,
        $url,
        $image
    ): self
    {
        return new self(
            new CellarId(CellarId::random()),
            new CellarName($name),
            new CellarUrl($url),
            new CellarImage($image),
            new CellarCreatedAt(new \DateTime())
        );
    }

    /**
     * @return CellarId
     */
    public function getId(): CellarId
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
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }
}