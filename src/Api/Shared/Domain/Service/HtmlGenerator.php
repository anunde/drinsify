<?php

namespace App\Api\Shared\Domain\Service;

interface HtmlGenerator
{
    public function generateWithPayload(string $template, array $payload): string;
}