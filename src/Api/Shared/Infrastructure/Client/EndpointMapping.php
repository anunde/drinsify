<?php

namespace App\Api\Shared\Infrastructure\Client;

abstract class EndpointMapping
{
    public const ENDPOINT_MAPPING = [
        'waiting_payment' => '/payment/wait',
        'failed_payment' => '/checkout'
    ];
}