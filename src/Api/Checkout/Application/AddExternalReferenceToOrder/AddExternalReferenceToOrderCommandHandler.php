<?php

namespace App\Api\Checkout\Application\AddExternalReferenceToOrder;

use App\Api\Shared\Domain\Exception\NotFoundException;
use App\Api\Shared\Domain\Repository\OrderRepositoryInterface;

final readonly class AddExternalReferenceToOrderCommandHandler
{
    public function __construct(
        private OrderRepositoryInterface $repository
    )
    {
    }

    /**
     * @throws NotFoundException
     */
    public function __invoke(AddExternalReferenceToOrderCommand $command): void
    {
        if (null === $order = $this->repository->findOneByInternalReferenceOrFail($command->getInternalReference())) {
            throw new NotFoundException('Order not found by internal reference: '. $command->getInternalReference());
        }

        $order->addExternalReference($command->getExternalReference());
        $this->repository->save($order);
    }
}