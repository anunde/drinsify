<?php

namespace App\Api\Profile\Infrastructure\Mailing;

abstract class TemplateMapping
{
    public const TEMPLATE_MAPPING = [
        'user_requests_token' => 'logistics/user_requests_token.html.twig'
    ];
}