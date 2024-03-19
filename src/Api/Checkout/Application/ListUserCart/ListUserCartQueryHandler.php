<?php

namespace App\Api\Checkout\Application\ListUserCart;

use App\Api\Checkout\Domain\Repository\CartRepositoryInterface;

final readonly class ListUserCartQueryHandler
{
    public function __construct(
        private CartRepositoryInterface $cartRepository
    )
    {
    }

    public function __invoke(ListUserCartQuery $query): array
    {
        $products =  $this->cartRepository->findOneWithProductsArray($query->getUserId());

        foreach ($products as &$product) {
            $taxes = \json_decode($product['taxes'], true);
            $tax_amount = 0;

            foreach ($taxes as $tax) {
                if (!$tax['exchange']) {
                    $tax_amount += $product['price'] * $tax['value']/100;
                }
            }

            $product['taxes'] = \number_format($tax_amount, 2, ',', '.');
            $product['total'] = \number_format($product['price'] + $tax_amount, 2, ',', '.');
        }

        return $products;
    }
}