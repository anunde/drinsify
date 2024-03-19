<?php

namespace App\Api\Shared\Domain\Entity;

use App\Shared\Domain\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="token")
 */
final class Token extends Entity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="token_id", unique=true)
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private TokenId $id;

    /**
     * @ORM\Column(type="user_id", nullable=false)
     */
    private UserId $userId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Api\Shared\Domain\Entity\Product", inversedBy="tokens")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private Product $product;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private ?float $price = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $txHash = null;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $tokenNumber = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $externalUrl = null;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $inSale;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $isRequested;

    public function __construct(
        TokenId $id,
        UserId $userId,
        Product $product,
        ?TokenPrice $price,
        ?TokenTxHash $txHash,
        ?TokenNumber $tokenNumber,
        ?TokenExternalUrl $externalUrl,
        TokenInSale $inSale,
        TokenIsRequested $isRequested
    )
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->product = $product;
        $this->price = $price?->value();
        $this->txHash = $txHash?->value();
        $this->tokenNumber = $tokenNumber?->value();
        $this->externalUrl = $externalUrl?->value();
        $this->inSale = $inSale->value();
        $this->isRequested = $isRequested->value();
    }

    public static function create(
        string $userId,
        Product $product
    ): self
    {
        return new self(
            new TokenId(TokenId::random()),
            new UserId($userId),
            $product,
            null,
            null,
            null,
            null,
            new TokenInSale(0),
            new TokenIsRequested(0)
        );
    }

    /**
     * @return TokenId
     */
    public function getId(): TokenId
    {
        return $this->id;
    }

    /**
     * @return UserId
     */
    public function getUserId(): UserId
    {
        return $this->userId;
    }

    /**
     * @return ProductId
     */
    public function getProductId(): ProductId
    {
        return $this->productId;
    }

    /**
     * @return float|null
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @return string|null
     */
    public function getTxHash(): ?string
    {
        return $this->txHash;
    }

    /**
     * @return int|null
     */
    public function getTokenNumber(): ?int
    {
        return $this->tokenNumber;
    }

    /**
     * @return string|null
     */
    public function getExternalUrl(): ?string
    {
        return $this->externalUrl;
    }

    /**
     * @return bool
     */
    public function isInSale(): bool
    {
        return $this->inSale;
    }

    /**
     * @return bool
     */
    public function isRequested(): bool
    {
        return $this->isRequested;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }

    public function putUpForSale(TokenPrice $price): void
    {
        $this->inSale = true;
        $this->price = $price->value();
    }

    public function cancelSale(): void
    {
        $this->inSale = false;
        $this->price = null;
    }

    public function addTxHash(TokenTxHash $txHash): void
    {
        $this->txHash = $txHash->value();
    }

    public function addTokenInfo(TokenNumber $number, TokenExternalUrl $externalUrl): void
    {
        $this->tokenNumber = $number->value();
        $this->externalUrl = $externalUrl->value();
    }

    public function requestsToken(): void
    {
        $this->inSale = false;
        $this->isRequested = true;
    }
}