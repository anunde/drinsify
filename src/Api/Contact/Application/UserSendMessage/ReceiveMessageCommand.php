<?php

namespace App\Api\Contact\Application\UserSendMessage;

final readonly class ReceiveMessageCommand
{
    public function __construct(
        private string $email,
        private string $message,
        private string $subject,
        private string $templatePath
    )
    {
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @return string
     */
    public function getTemplatePath(): string
    {
        return $this->templatePath;
    }
}