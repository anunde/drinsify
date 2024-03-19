<?php

namespace App\Api\Shared\Infrastructure\Service;

use App\Api\Shared\Domain\Service\HtmlGenerator as HtmlGeneratorInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

readonly class HtmlGenerator implements  HtmlGeneratorInterface
{
    public function __construct(
        private Environment $environment,
    )
    {
    }

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function generateWithPayload(string $template, array $payload): string
    {
        return $this->environment->render($template, $payload);
    }
}