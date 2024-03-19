<?php

namespace App\Api\Checkout\Infrastructure\Mailing;

abstract class TemplateMapping
{
    public const TEMPLATE_MAPPING = [
        'purchase' => 'checkout/user_purchase.html.twig'
    ];
}