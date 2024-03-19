<?php

namespace App\Api\Subscription\Domain\Repository;

use App\Api\Subscription\Domain\Entity\Subscriber;

interface SubscribeRepositoryInterface
{
    public function save(Subscriber $subscriber): void;

    public function checkIfNotExistsByEmailOrFail(string $email): void;
}