<?php

namespace App\Api\Shared\Infrastructure\Mailing;

use App\Api\Shared\Domain\Mailing\MailerDomain;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class Mailer implements MailerDomain
{
    private string $templateSubject;
    public function __construct(
        private readonly string          $mailerDefaultSender,
        private readonly MailerInterface $mailer,
        private readonly LoggerInterface $logger
    )
    {
    }

    public function send(string $receiver, string $subject, string $html): void
    {
        $email = (new Email())
            ->from($this->mailerDefaultSender)
            ->to($receiver)
            ->subject($subject)
            ->html($html);

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            $this->logger->error(\sprintf('Error sending email: %s', $e->getMessage()));
        }
    }
}