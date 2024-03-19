<?php

namespace App\Api\Catalogue\Application\SendRequestBuyAllSeries;

use App\Api\Shared\Domain\Mailing\MailerDomain;
use App\Api\Shared\Domain\Service\HtmlGenerator;

final readonly class SendRequestBuyAllSeriesCommandHandler
{
    public function __construct(
        private HtmlGenerator $generator,
        private MailerDomain $mailer
    )
    {
    }

    public function __invoke(SendRequestBuyAllSeriesCommand $command): void
    {
        $payload = [
            'email' => $command->getUserEmail(),
            'id' => $command->getProductId(),
            'name' => $command->getProductName()
        ];

        $this->mailer->send(
            $command->getReceiverEmail(),
            $command->getSubject(),
            $this->generator->generateWithPayload($command->getTemplatePath(), $payload)
        );
    }
}