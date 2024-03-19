<?php

namespace App\Api\Contact\Infrastructure\Listener;

use App\Api\Contact\Application\UserSendMessage\ReceiveMessageCommand;
use App\Api\Contact\Application\UserSendMessage\ReceiveMessageCommandHandler;
use App\Api\Contact\Domain\Event\UserSendMessageEvent;
use App\Api\Contact\Infrastructure\Mailing\SubjectMapping;
use App\Api\Contact\Infrastructure\Mailing\TemplateMapping;
use App\Api\Shared\Domain\Mailing\MailerDomain;

final readonly class UserSendMessageListener
{
    public function __construct(
        private MailerDomain                        $mailer,
        private ReceiveMessageCommandHandler $commandHandler,
        private string                              $host
    )
    {
    }


    public function onUserSendMessage(UserSendMessageEvent $event): void
    {
        $this->commandHandler->__invoke(new ReceiveMessageCommand(
            $event->getContactForm()->getEmail(),
            $event->getContactForm()->getMessage(),
            SubjectMapping::SUBJECT_MAP['contact'],
            TemplateMapping::TEMPLATE_MAP['contact']
        ));
    }
}