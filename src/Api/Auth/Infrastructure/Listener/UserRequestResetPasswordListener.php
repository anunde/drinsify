<?php

namespace App\Api\Auth\Infrastructure\Listener;

use App\Api\Auth\Application\SendUserResetPasswordEmail\SendUserResetPasswordEmailCommand;
use App\Api\Auth\Application\SendUserResetPasswordEmail\SendUserResetPasswordEmailCommandHandler;
use App\Api\Auth\Domain\Event\UserRequestResetPasswordEvent;
use App\Api\Auth\Infrastructure\Mailing\SubjectMapping;
use App\Api\Auth\Infrastructure\Mailing\TemplateMapping;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

readonly class UserRequestResetPasswordListener
{
    public function __construct(
        private SendUserResetPasswordEmailCommandHandler $commandHandler
    )
    {
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function onUserRequestPassword(UserRequestResetPasswordEvent $event): void
    {
        $this->commandHandler->__invoke(new SendUserResetPasswordEmailCommand(
            $event->getUserId(),
            $event->getUserName(),
            $event->getUserEmail(),
            $event->getResetPasswordToken(),
            SubjectMapping::SUBJECT_MAP['request_reset_password'],
            TemplateMapping::TEMPLATE_MAP['request_reset_password']
        ));
    }
}