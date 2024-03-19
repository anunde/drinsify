<?php

namespace App\Api\Checkout\Application\GenerateOrderFromCart;

use App\Api\Checkout\Domain\Entity\Order;
use App\Api\Checkout\Infrastructure\Persistence\Repository\CartRepository;
use App\Api\Shared\Domain\Exception\ConflictException;
use App\Api\Shared\Domain\Exception\NotFoundException;
use App\Api\Shared\Infrastructure\Persistence\Repository\OrderRepository;
use Doctrine\ORM\NonUniqueResultException;

final readonly class GenerateOrderFromCartCommandHandler
{
    public function __construct(
        private OrderRepository $orderRepository,
        private CartRepository $cartRepository
    )
    {
    }

    /**
     * @throws NonUniqueResultException
     * @throws NotFoundException
     * @throws ConflictException
     */
    public function __invoke(GenerateOrderFromCartCommand $command): string
    {
        $this->orderRepository->checkIfNotExistsActivatedOrder($command->getUserId());
        $cart = $this->cartRepository->findOneWithLinesAndProductInfoOrFail($command->getUserId());
        $order = Order::create($command->getUserId(), $command->getMethod(), \sha1(\uniqid()));

        foreach ($cart->getLines() as $line) {
            $taxes = \array_filter(\json_decode($line['taxes'], true), function ($tax) {
                return !$tax['exchange'];
            });

            $order->addLine(
                $line['productId'],
                $line['price'],
                $taxes,
                $line['quantity']
            );
        }

        $this->orderRepository->save($order);
        return $order->getInternalReference()->value();
    }
}