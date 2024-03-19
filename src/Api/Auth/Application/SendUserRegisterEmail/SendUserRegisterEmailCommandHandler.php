<?php

namespace App\Api\Auth\Application\SendUserRegisterEmail;

use App\Api\Shared\Domain\Mailing\MailerDomain;
use App\Api\Shared\Domain\Service\HtmlGenerator;

final readonly class SendUserRegisterEmailCommandHandler
{
    public function __construct(
        private string $host,
        private HtmlGenerator $htmlGenerator,
        private MailerDomain $mailer
    )
    {
    }

    public function __invoke(SendUserRegisterEmailCommand $command): void
    {
        $payload = [
            'name' => $command->getName(),
            'url' => \sprintf(
                '%s%s?token=%s&uid=%s',
                $this->host,
                '/activate_account',
                $command->getToken(),
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