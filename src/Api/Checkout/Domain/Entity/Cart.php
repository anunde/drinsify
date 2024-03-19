<?php

namespace App\Api\Checkout\Domain\Entity;

use App\Api\Shared\Domain\Entity\ProductId;
use App\Api\Shared\Domain\Entity\UserId;
use App\Shared\Domain\Entity;

final class Cart extends Entity
{
    private array $lines = [];

    public function __construct(
        private readonly CartId        $id,
        private UserId        $userId,
        private readonly CartCreatedAt $createdAt,
        private CartUpdatedAt $updatedAt
    )
    {
    }

    public static function create(
        $userId
    ): self
    {
        return new self(
            new CartId(CartId::random()),
            new UserId($userId),
            new CartCreatedAt(new \DateTime()),
            new CartUpdatedAt(new \DateTime())
        );
    }

    /**
     * @return CartId
     */
    public function getId(): CartId
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
     * @return CartCreatedAt
     */
    public function getCreatedAt(): CartCreatedAt
    {
        return $this->createdAt;
    }

    /**
     * @return array
     */
    public function getLines(): array
    {
        return $this->lines;
    }

    public function updateTimestamps(): void
    {
        $this->updatedAt = new CartUpdatedAt(new \DateTime());
    }

    public function setLines(array $lines): void
    {
        $this->lines = $lines;
    }

    public function removeLine(string $productId): void
    {
        foreach ($this->lines as $index => $line) {
            if ($line->getProductId()->equals(new ProductId($productId))){
                unset($this->lines[$index]);
            }
        }
    }

    public function addProduct(string $productId): ?CartLine
    {
        foreach ($this->lines as $line) {
            if ($line->getProductId()->equals(new ProductId($productId))){
                $line->increaseQuantity();
                return null;
            }
        }

        $line = CartLine::create($this->getId(), $productId);
        $this->lines[] = $line;
        return $line;
    }

    public function subtractProduct(string $productId): void
    {
        foreach ($this->lines as $line) {
            if ($line->getProductId()->equals(new ProductId($productId))) {
                $line->decreaseQuantity();
            }
        }

        $this->lines = array_values($this->lines);
    }
}