<?php

namespace App\Api\Shared\Domain\Mailing;

interface MailerDomain
{
    public function send(string $receiver, string $subject, string $html): void;
}