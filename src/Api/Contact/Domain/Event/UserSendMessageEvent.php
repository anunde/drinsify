<?php

namespace App\Api\Contact\Domain\Event;

use App\Api\Contact\Domain\Message\ContactFormMessageDTO;
use App\Api\Shared\Domain\Event\DomainEvent;

class UserSendMessageEvent extends DomainEvent
{
    public const NAME_EVENT = "user.sendMessage";

    public function __construct(protected ContactFormMessageDTO $contactForm)
    {
    }

    public function getContactForm(): ContactFormMessageDTO
    {
        return $this->contactForm;
    }
}