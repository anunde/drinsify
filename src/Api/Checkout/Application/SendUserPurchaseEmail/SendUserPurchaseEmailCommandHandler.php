<?php

namespace App\Api\Checkout\Application\SendUserPurchaseEmail;

use App\Api\Auth\Domain\Repository\UserRepositoryInterface;
use App\Api\Shared\Domain\Mailing\MailerDomain;
use App\Api\Shared\Domain\Service\HtmlGenerator;

final readonly class SendUserPurchaseEmailCommandHandler
{
    public function __construct(
        private MailerDomain $mailer,
        private HtmlGenerator $generator,
        private UserRepositoryInterface $repository
    )
    {
    }

    public function __invoke(SendUserPurchaseEmailCommand $command): void
    {
        if (null !== $user = $this->repository->findOneById($command->getUserEmail()))
        {
            $payload = [
                'name' => 'enviar'
            ];

            $this->mailer->send(
                $user->getEmail(),
                $command->getSubject(),
                $this->generator->generateWithPayload($command->getTemplatePath(), $payload)
            );
        }
    }
}