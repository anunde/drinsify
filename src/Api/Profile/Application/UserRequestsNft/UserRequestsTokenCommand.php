<?php

namespace App\Api\Profile\Application\UserRequestsNft;

final readonly class UserRequestsTokenCommand
{
    public function __construct(
        private string $userId,
        private string $tokenId,
        private string $receiverEmail,
        private string $subject,
        private string $templatePath
    )
    {
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getTokenId(): string
    {
        return $this->tokenId;
    }

    /**
     * @return string
     */
    public function getReceiverEmail(): string
    {
        return $this->receiverEmail;
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