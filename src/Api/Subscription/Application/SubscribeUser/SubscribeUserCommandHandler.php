<?php

namespace App\Api\Subscription\Application\SubscribeUser;

use App\Api\Subscription\Domain\Entity\Subscriber;
use App\Api\Subscription\Domain\Repository\SubscribeRepositoryInterface;

final readonly class SubscribeUserCommandHandler
{
    public function __construct(
        private SubscribeRepositoryInterface $repository
    )
    {
    }

    public function __invoke(SubscribeUserCommand $command): void
    {
        $this->repository->checkIfNotExistsByEmailOrFail($command->getEmail());
        $subscriber = Subscriber::create($command->getEmail());
        $this->repository->save($subscriber);
    }
}