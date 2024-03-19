<?php

namespace App\Api\Contact\Application\UserSendMessage;

use App\Api\Shared\Domain\Mailing\MailerDomain;
use App\Api\Shared\Domain\Service\HtmlGenerator;

final readonly class ReceiveMessageCommandHandler
{
    public function __construct(
        private string $host,
        private HtmlGenerator $htmlGenerator,
        private MailerDomain $mailer
    )
    {
    }

    public function __invoke(ReceiveMessageCommand $command): void
    {
        $payload = [
            'email' => $command->getEmail(),
            'message' => $command->getMessage()
        ];

        $this->mailer->send(
            $command->getEmail(),
            $command->getSubject(),
            $this->htmlGenerator->generateWithPayload($command->getTemplatePath(), $payload)
        );
    }
}