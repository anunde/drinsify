<?php

namespace App\Api\Auth\Infrastructure\Mailing;

abstract class TemplateMapping
{
    public const TEMPLATE_MAP = [
        'register' => 'user/registered.html.twig',
        'request_reset_password' => 'user/request_reset_password.html.twig'
    ];
}