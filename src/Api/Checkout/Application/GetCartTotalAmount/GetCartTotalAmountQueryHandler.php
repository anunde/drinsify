<?php

namespace App\Api\Checkout\Application\GetCartTotalAmount;

use App\Api\Checkout\Domain\Repository\CartRepositoryInterface;

final readonly class GetCartTotalAmountQueryHandler
{
    public function __construct(
        private CartRepositoryInterface $cartRepository
    )
    {
    }

    public function __invoke(GetCartTotalAmountQuery $query): float
    {
        $cart = $this->cartRepository->findOneWithLinesAndProductInfoOrFail($query->getUserId());
        $total = 0;

        foreach ($cart->getLines() as $line) {
            $taxes = \json_decode($line['taxes'], true);

            $tax_amount = array_reduce($taxes, function ($carry, $tax) {
                return $carry + (!$tax['exchange'] ? $tax['value'] : 0);
            }, 0);

            $tax_amount = $tax_amount/100 * $line['price'];
            $total += $line['quantity'] * ($tax_amount + $line['price']);
        }

        return $total;
    }
}