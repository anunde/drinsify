<?php

namespace App\Api\Catalogue\Domain\Entity;

use App\Api\Shared\Domain\Entity\Product;
use App\Api\Shared\Domain\Entity\ProductId;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="product_info")
 */
final class ProductInfo
{
    /**
     * @ORM\Id
     * @ORM\Column(type="product_info_id", unique=true)
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private ProductInfoId $id;

    /**
     * @ORM\Column(type="product_id", nullable=false)
     */
    private ProductId $productId;

    /**
     * @ORM\Column(type="text", nullable=false)
     */
    private string $features;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private string $image;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private string $dataSheet;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private string $awards;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private string $existenceProof;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private int $daysDelivery;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private string $qr;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private \DateTime $minRequestDate;

    /**
     * @ORM\OneToOne(targetEntity="App\Api\Shared\Domain\Entity\Product", inversedBy="productInfo", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private Product $product;


    public function __construct(
        ProductInfoId $id,
        ProductId $productId,
        ProductInfoFeatures $features,
        ProductInfoImage $image,
        ProductInfoDataSheet $dataSheet,
        ProductInfoAwards $awards,
        ProductInfoExistenceProof $existenceProof,
        ProductInfoDaysDelivery $daysDelivery,
        ProductInfoQr $qr,
        ProductInfoMinRequestDate $minRequestDate
    )
    {
        $this->id = $id;
        $this->productId = $productId;
        $this->features = $features->value();
        $this->image = $image->value();
        $this->dataSheet = $dataSheet->value();
        $this->awards = $awards->value();
        $this->existenceProof = $existenceProof->value();
        $this->daysDelivery = $daysDelivery->value();
        $this->qr = $qr->value();
        $this->minRequestDate = $minRequestDate->value();
    }

    public static function create(
        $productId,
        $features,
        $image,
        $dataSheet,
        $awards,
        $existenceProof,
        $daysDelivery,
        $qr,
        $requestDate
    ): self
    {
        return new self(
            new ProductInfoId(ProductInfoId::random()),
            new ProductId($productId),
            new ProductInfoFeatures(\json_encode($features)),
            new ProductInfoImage($image),
            new ProductInfoDataSheet($dataSheet),
            new ProductInfoAwards($awards),
            new ProductInfoExistenceProof($existenceProof),
            new ProductInfoDaysDelivery($daysDelivery),
            new ProductInfoQr($qr),
            new ProductInfoMinRequestDate(new \DateTime($requestDate))
        );
    }

    /**
     * @return ProductInfoId
     */
    public function getId(): ProductInfoId
    {
        return $this->id;
    }

    /**
     * @return ProductId
     */
    public function getProductId(): ProductId
    {
        return $this->productId;
    }

    /**
     * @return string
     */
    public function getFeatures(): string
    {
        return $this->features;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @return string
     */
    public function getDataSheet(): string
    {
        return $this->dataSheet;
    }

    /**
     * @return string
     */
    public function getAwards(): string
    {
        return $this->awards;
    }

    /**
     * @return string
     */
    public function getExistenceProof(): string
    {
        return $this->existenceProof;
    }

    /**
     * @return int
     */
    public function getDaysDelivery(): int
    {
        return $this->daysDelivery;
    }

    /**
     * @return string
     */
    public function getQr(): string
    {
        return $this->qr;
    }

    /**
     * @return \DateTime
     */
    public function getMinRequestDate(): \DateTime
    {
        return $this->minRequestDate;
    }

    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }
}