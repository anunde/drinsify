<?php

namespace App\Api\Checkout\Application\SetOrderPaid;


use App\Api\Checkout\Domain\Event\OrderPaidEvent;
use App\Api\Shared\Domain\Event\EventDispatcherInterface;
use App\Api\Shared\Domain\Exception\NotFoundException;
use App\Api\Shared\Infrastructure\Persistence\Repository\OrderRepository;
use Doctrine\ORM\NonUniqueResultException;

final readonly class SetOrderPaidCommandHandler
{
    public function __construct(
        private OrderRepository $repository,
        private EventDispatcherInterface $dispatcher
    )
    {
    }

    /**
     * @throws NonUniqueResultException
     * @throws NotFoundException
     */
    public function __invoke(SetOrderPaidCommand $command): void
    {
        if(null === $order = $this->repository->findOneByInternalReferenceOrFail($command->getInternalReference())) {
            throw new NotFoundException(\sprintf("Couldn't find order by internal reference: %s", $command->getInternalReference()));
        }

        $order->setPaid($command->getExternalReference());
        $this->repository->save($order);

        $this->dispatcher->dispatch(new OrderPaidEvent(
            $order->getUserId(),
            $order->getInternalReference()->value()
        ));
    }
}