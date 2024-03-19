<?php

namespace App\Api\Contact\Domain\Entity;

use App\Shared\Domain\Entity;

class ContactForm extends Entity
{
    public function __construct(
        private ContactFormEmail $email,
        private ContactFormMessage $message
    )
    {
    }

    public static function create(
        $email,
        $message
    ): self {
        return new self(
            new ContactFormEmail($email),
            new ContactFormMessage($message)
        );
    }

    /**
     * @return ContactFormEmail
     */
    public function getEmail(): ContactFormEmail
    {
        return $this->email;
    }

    /**
     * @return ContactFormMessage
     */
    public function getMessage(): ContactFormMessage
    {
        return $this->message;
    }
}