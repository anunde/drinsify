<?php

namespace App\Api\Checkout\Application\GenerateMercadopagoPreferenceId;

final readonly class GenerateMercadopagoPreferenceIdQuery
{
    public function __construct(
        private string $userId,
        private string $internalReference,
        private string $accessToken,
        private string $clientHost,
        private string $waitingEndpoint,
        private string $failureEndpoint
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
    public function getInternalReference(): string
    {
        return $this->internalReference;
    }

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    /**
     * @return string
     */
    public function getClientHost(): string
    {
        return $this->clientHost;
    }

    /**
     * @return string
     */
    public function getWaitingEndpoint(): string
    {
        return $this->waitingEndpoint;
    }

    /**
     * @return string
     */
    public function getFailureEndpoint(): string
    {
        return $this->failureEndpoint;
    }
}