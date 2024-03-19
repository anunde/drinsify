<?php

namespace App\Api\Shared\Infrastructure\Mailing;

use App\Api\Shared\Domain\Mailing\MailerDomain;

class MailerTest implements MailerDomain
{

    public function send(string $receiver, string $subject, string $html): void
    {
        // TODO: Implement send() method.
    }
}