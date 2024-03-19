<?php

namespace App\Api\Contact\Domain\Message;

use App\Api\Contact\Domain\Entity\ContactFormEmail;
use App\Api\Contact\Domain\Entity\ContactFormMessage;

final readonly class ContactFormMessageDTO
{
    public function __construct(
        private ContactFormEmail $email,
        private ContactFormMessage      $message
    )
    {
    }

    public function getEmail(): string
    {
        return $this->email->value();
    }

    public function getMessage(): string
    {
        return $this->message->value();
    }


}