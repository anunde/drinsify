<?php

namespace App\Api\Subscription\Domain\Entity;

use App\Shared\Domain\Entity;

class Subscriber extends Entity
{
    public function __construct(
        private readonly SubscriberId $id,
        private SubscriberEmail $email,
        private readonly SubscriberCreatedAt $createdAt
    )
    {
    }

    public static function create(
        $email
    ): self
    {
        return new self(
            new SubscriberId(SubscriberId::random()),
            new SubscriberEmail($email),
            new SubscriberCreatedAt(new \DateTime())
        );
    }

    /**
     * @return SubscriberId
     */
    public function getId(): SubscriberId
    {
        return $this->id;
    }

    /**
     * @return SubscriberEmail
     */
    public function getEmail(): SubscriberEmail
    {
        return $this->email;
    }

    /**
     * @return SubscriberCreatedAt
     */
    public function getCreatedAt(): SubscriberCreatedAt
    {
        return $this->createdAt;
    }
}