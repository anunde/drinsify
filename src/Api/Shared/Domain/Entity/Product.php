<?php

namespace App\Api\Shared\Domain\Entity;

use App\Api\Catalogue\Domain\Entity\BrandId;
use App\Api\Catalogue\Domain\Entity\DenominationId;
use App\Api\Catalogue\Domain\Entity\OriginId;
use App\Api\Catalogue\Domain\Entity\ProductInfo;
use App\Shared\Domain\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="product")
 */
class Product extends Entity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="product_id", unique=true)
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private ProductId $id;

    /**
     * @ORM\Column(type="origin_id", nullable=false)
     */
    private OriginId $originId;

    /**
     * @ORM\Column(type="denomination_id", nullable=false)
     */
    private DenominationId $denominationId;

    /**
     * @ORM\Column(type="brand_id", nullable=false)
     */
    private BrandId $brandId;

    /**
     * @ORM\Column(type="cellar_id", nullable=false)
     */
    private CellarId $cellarId;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private string $name;

    /**
     * @ORM\Column(type="text", nullable=false)
     */
    private string $description;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private string $thumbnail;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private int $quantity;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private bool $status;

    /**
     * @ORM\Column(type="float", nullable=false)
     */
    private float $price;

    /**
     * @ORM\Column(type="text", nullable=false)
     */
    private string $taxes;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private string $countriesAvailable;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private \DateTime $createdAt;

    /**
     * @ORM\OneToOne(targetEntity="App\Api\Catalogue\Domain\Entity\ProductInfo", mappedBy="product", cascade={"persist", "remove"})
     */
    private ?ProductInfo $productInfo = null;

    /**
     * @ORM\OneToMany(targetEntity="App\Api\Shared\Domain\Entity\Token", mappedBy="product")
     */
    private Collection $tokens;


    public function __construct(
        ProductId        $id,
        OriginId                  $originId,
        DenominationId            $denominationId,
        BrandId                   $brandId,
        CellarId                  $cellarId,
        ProductName               $name,
        ProductDescription        $description,
        ProductThumbnail          $thumbnail,
        ProductQuantity           $quantity,
        ProductStatus             $status,
        ProductPrice              $price,
        ProductTaxes              $taxes,
        ProductCountriesAvailable $countriesAvailable,
        ProductCreatedAt $createdAt,
        ?ProductInfo $productInfo
    )
    {
        $this->id = $id;
        $this->originId = $originId;
        $this->denominationId = $denominationId;
        $this->brandId = $brandId;
        $this->cellarId = $cellarId;
        $this->name = $name->value();
        $this->description = $description->value();
        $this->thumbnail = $thumbnail->value();
        $this->quantity = $quantity->value();
        $this->status = $status->value();
        $this->price = $price->value();
        $this->taxes = $taxes->value();
        $this->countriesAvailable = $countriesAvailable->value();
        $this->createdAt = $createdAt->value();
        $this->productInfo = $productInfo !== null ? $productInfo : null;
        $this->tokens = new ArrayCollection();
    }

    public static function create(
        $originId,
        $denominationId,
        $brandId,
        $cellarId,
        $name,
        $description,
        $thumbnail,
        $quantity,
        $status,
        $price,
        $taxes,
        $countriesAvailable
    ): self
    {
        return new self(
            new ProductId(ProductId::random()),
            new OriginId($originId),
            new DenominationId($denominationId),
            new BrandId($brandId),
            new CellarId($cellarId),
            new ProductName($name),
            new ProductDescription($description),
            new ProductThumbnail($thumbnail),
            new ProductQuantity($quantity),
            new ProductStatus($status),
            new ProductPrice($price),
            new ProductTaxes(\json_encode($taxes)),
            new ProductCountriesAvailable($countriesAvailable),
            new ProductCreatedAt(new \DateTime()),
            null
        );
    }

    /**
     * @throws \Exception
     */
    public static function fromPrimitives(array $data): self
    {
        return new self(
            new ProductId($data['id']),
            new OriginId($data['origin_id']),
            new DenominationId($data['denomination_id']),
            new BrandId($data['brand_id']),
            new CellarId($data['cellar_id']),
            new ProductName($data['name']),
            new ProductDescription($data['description']),
            new ProductThumbnail($data['image']),
            new ProductQuantity($data['quantity']),
            new ProductExtension($data['extension']),
            new ProductStatus($data['status']),
            new ProductPrice($data['price']),
            new ProductTaxes($data['taxes']),
            new ProductCountriesAvailable($data['countries_available']),
            new ProductCreatedAt(new \DateTime($data['created_at']))
        );
    }

    public static function toPrimitives(Product $product): array
    {
        return [
            'id' => $product->getId()->value(),
            'originId' => $product->getOriginId()->value(),
            'denominationId' => $product->getDenominationId()->value(),
            'brandId' => $product->getBrandId()->value(),
            'cellarId' => $product->getCellarId()->value(),
            'name' => $product->getName()->value(),
            'description' => $product->getDescription()->value(),
            'thumbnail' => $product->getThumbnail()->value(),
            'quantity' => $product->getQuantity()->value(),
            'status' => $product->getStatus()->value(),
            'price' => $product->getPrice()->value(),
            'taxes' => \json_decode($product->getTaxes()->value(), true),
            'countriesAvailable' => $product->getCountriesAvailable()->value()
        ];
    }

    /**
     * @return ProductId
     */
    public function getId(): ProductId
    {
        return $this->id;
    }

    /**
     * @return OriginId
     */
    public function getOriginId(): OriginId
    {
        return $this->originId;
    }

    /**
     * @return DenominationId
     */
    public function getDenominationId(): DenominationId
    {
        return $this->denominationId;
    }

    /**
     * @return BrandId
     */
    public function getBrandId(): BrandId
    {
        return $this->brandId;
    }

    /**
     * @return CellarId
     */
    public function getCellarId(): CellarId
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
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @return bool
     */
    public function isStatus(): bool
    {
        return $this->status;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @return string
     */
    public function getTaxes(): string
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
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setProductInfo(ProductInfo $productInfo): void
    {
        $this->productInfo = $productInfo;
        $productInfo->setProduct($this);
    }

    public function getProductInfo(): ?ProductInfo
    {
        return $this->productInfo;
    }

    public function subtractQuantity(): void {
        $this->quantity = $this->quantity - 1;
    }

    public function addQuantity(): void {
        $this->quantity = $this->quantity + 1;
    }

    public function addNumberQuantity(int $number): void
    {
        $this->quantity = $this->quantity + $number;
    }

    public function getTokens(): Collection {
        return $this->tokens;
    }
}