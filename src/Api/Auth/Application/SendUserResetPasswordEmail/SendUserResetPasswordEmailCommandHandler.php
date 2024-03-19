<?php

namespace App\Api\Auth\Application\SendUserResetPasswordEmail;

use App\Api\Shared\Domain\Mailing\MailerDomain;
use App\Api\Shared\Infrastructure\Service\HtmlGenerator;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

final readonly class SendUserResetPasswordEmailCommandHandler
{
    public function __construct(
        private string $host,
        private MailerDomain $mailer,
        private HtmlGenerator $htmlGenerator
    )
    {
    }

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function __invoke(SendUserResetPasswordEmailCommand $command): void
    {
        $payload = [
            'name' => $command->getName(),
            'url' => \sprintf(
                '%s%s?token=%s&uid=%s',
                $this->host,
                '/reset_password',
                $command->getResetPasswordToken(),
                $command->getId()
            )
        ];

        $this->mailer->send(
            $command->getEmail(),
            $command->getSubject(),
            $this->htmlGenerator->generateWithPayload($command->getTemplatePath(), $payload)
        );
    }
}