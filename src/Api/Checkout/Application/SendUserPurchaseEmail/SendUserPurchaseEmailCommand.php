<?php

namespace App\Api\Checkout\Application\SendUserPurchaseEmail;

final readonly class SendUserPurchaseEmailCommand
{
    public function __construct(
        private string $userEmail,
        private string $subject,
        private string $templatePath
    )
    {
    }

    /**
     * @return string
     */
    public function getUserEmail(): string
    {
        return $this->userEmail;
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