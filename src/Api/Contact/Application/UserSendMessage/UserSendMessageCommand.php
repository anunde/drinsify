<?php

namespace App\Api\Contact\Application\UserSendMessage;

final readonly class UserSendMessageCommand
{
    public function __construct(
        private string $email,
        private string $message
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

}