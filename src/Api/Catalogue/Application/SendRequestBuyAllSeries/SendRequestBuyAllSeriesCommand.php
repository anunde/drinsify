<?php

namespace App\Api\Catalogue\Application\SendRequestBuyAllSeries;

final readonly class SendRequestBuyAllSeriesCommand
{
    public function __construct(
        private string $receiverEmail,
        private string $userEmail,
        private string $productId,
        private string $productName,
        private string $subject,
        private string $templatePath
    )
    {
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
    public function getUserEmail(): string
    {
        return $this->userEmail;
    }

    /**
     * @return string
     */
    public function getProductId(): string
    {
        return $this->productId;
    }

    /**
     * @return string
     */
    public function getProductName(): string
    {
        return $this->productName;
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