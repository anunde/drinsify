<?php

namespace App\Api\Contact\Application\UserSendMessage;

use App\Api\Contact\Domain\Entity\ContactForm;
use App\Api\Contact\Domain\Event\UserSendMessageEvent;
use App\Api\Contact\Domain\Message\ContactFormMessageDTO;
use App\Api\Shared\Domain\Event\EventDispatcherInterface;

final readonly class UserSendMessageCommandHandler
{
    public function __construct(
        private EventDispatcherInterface $dispatcher,
    )
    {
    }

    public function __invoke(UserSendMessageCommand $command): void
    {
        $contactForm = ContactForm::create($command->getEmail(), $command->getMessage());
        $this->dispatcher->dispatch(new UserSendMessageEvent(new ContactFormMessageDTO($contactForm->getEmail(), $contactForm->getMessage())));
    }
}