<?php

namespace App\Api\Checkout\Domain\Entity;

use App\Api\Shared\Domain\Entity\UserId;
use App\Shared\Domain\Entity;
use phpDocumentor\Reflection\Types\True_;

final class Order extends Entity
{
    private array $lines = [];

    public function __construct(
        private readonly OrderId $id,
        private UserId           $userId,
        private OrderStatus $status,
        private OrderPaid $paid,
        private OrderTokenized $tokenized,
        private OrderMethod $method,
        private ?OrderExternalReference $externalReference,
        private OrderInternalReference $internalReference,
        private ?OrderFinishedAt $finishedAt,
        private readonly OrderCreatedAt $createdAt
    )
    {
    }

    public static function create(
        $userId,
        $method,
        $internalReference
    ): self
    {
        return new self(
            new OrderId(OrderId::random()),
            new UserId($userId),
            new OrderStatus(1),
            new OrderPaid(0),
            new OrderTokenized(0),
            new OrderMethod($method),
            null,
            new OrderInternalReference($internalReference),
            null,
            new OrderCreatedAt(new \DateTime())
        );
    }

    /**
     * @return OrderId
     */
    public function getId(): OrderId
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
     * @return OrderStatus
     */
    public function getStatus(): OrderStatus
    {
        return $this->status;
    }

    /**
     * @return OrderPaid
     */
    public function getPaid(): OrderPaid
    {
        return $this->paid;
    }

    /**
     * @return OrderTokenized
     */
    public function getTokenized(): OrderTokenized
    {
        return $this->tokenized;
    }

    /**
     * @return OrderMethod
     */
    public function getMethod(): OrderMethod
    {
        return $this->method;
    }

    /**
     * @return OrderExternalReference|null
     */
    public function getExternalReference(): ?OrderExternalReference
    {
        return $this->externalReference;
    }

    /**
     * @return OrderInternalReference|null
     */
    public function getInternalReference(): ?OrderInternalReference
    {
        return $this->internalReference;
    }

    /**
     * @return OrderFinishedAt|null
     */
    public function getFinishedAt(): ?OrderFinishedAt
    {
        return $this->finishedAt;
    }

    /**
     * @return OrderCreatedAt
     */
    public function getCreatedAt(): OrderCreatedAt
    {
        return $this->createdAt;
    }

    public function setLines(array $lines): void
    {
        $this->lines = $lines;
    }

    /**
     * @return array
     */
    public function getLines(): array
    {
        return $this->lines;
    }

    public function addLine(string $productId, float $price, array $taxes, int $quantity): void
    {
        $line = OrderLine::create(
            $this->getId(),
            $productId,
            $price,
            $taxes,
            $quantity
        );

        $this->lines[] = $line;
    }

    public function cancel(): void
    {
        $this->status = new OrderStatus(0);
    }

    public function setPaid($externalReference = null): void
    {
        $this->paid = new OrderPaid(1);
        $this->finishedAt = new OrderFinishedAt(new \DateTime());

        if (!empty($externalReference)) {
            $this->externalReference = new OrderExternalReference($externalReference);
        }
    }

    public function setTokenized(): void
    {
        $this->tokenized = new OrderTokenized(true);
    }

    public function addExternalReference(string $externalReference): void
    {
        $this->externalReference = new OrderExternalReference($externalReference);
    }
}