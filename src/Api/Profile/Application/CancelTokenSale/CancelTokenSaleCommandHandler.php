<?php

namespace App\Api\Profile\Application\CancelTokenSale;

use App\Api\Shared\Domain\Exception\ConflictException;
use App\Api\Shared\Domain\Exception\NotFoundException;
use App\Api\Shared\Infrastructure\Persistence\Repository\TokenRepository;
use Doctrine\ORM\NonUniqueResultException;

final readonly class CancelTokenSaleCommandHandler
{
    public function __construct(
        private TokenRepository $repository
    )
    {
    }

    /**
     * @throws NotFoundException
     * @throws ConflictException
     * @throws NonUniqueResultException
     */
    public function __invoke(CancelTokenSaleCommand $command): void
    {
        if (null === $token = $this->repository->findById($command->getTokenId())){
            throw new NotFoundException('Token not found');
        }

        if ($command->getUserId() != $token->getUserId()) {
            throw new ConflictException("You aren't the owner of this Token");
        }

        $token->cancelSale();
        $this->repository->save($token);
    }
}