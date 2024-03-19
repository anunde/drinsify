<?php

namespace App\Api\Catalogue\Infrastructure\Mailing;

abstract class TemplateMapping
{
    public const TEMPLATE_MAP = [
        'request_series' => 'catalogue/request_buy_all_series.html.twig'
    ];
}