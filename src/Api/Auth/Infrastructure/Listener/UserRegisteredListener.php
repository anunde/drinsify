<?php

namespace App\Api\Auth\Infrastructure\Listener;

use App\Api\Auth\Application\SendUserRegisterEmail\SendUserRegisterEmailCommand;
use App\Api\Auth\Application\SendUserRegisterEmail\SendUserRegisterEmailCommandHandler;
use App\Api\Auth\Domain\Event\UserRegisteredEvent;
use App\Api\Auth\Infrastructure\Mailing\SubjectMapping;
use App\Api\Auth\Infrastructure\Mailing\TemplateMapping;
use App\Api\Shared\Domain\Mailing\MailerDomain;
use App\Api\Shared\Infrastructure\UrlWithTokenGenerator;


readonly class UserRegisteredListener
{
    public function __construct(
        private MailerDomain                        $mailer,
        private SendUserRegisterEmailCommandHandler $commandHandler,
        private string                              $host
    )
    {
    }


    public function onUserRegistered(UserRegisteredEvent $event): void
    {
        $this->commandHandler->__invoke(new SendUserRegisterEmailCommand(
            $event->getUserId(),
            $event->getUserEmail(),
            $event->getUserName(),
            $event->getToken(),
            SubjectMapping::SUBJECT_MAP['register'],
            TemplateMapping::TEMPLATE_MAP['register']
        ));
    }
}