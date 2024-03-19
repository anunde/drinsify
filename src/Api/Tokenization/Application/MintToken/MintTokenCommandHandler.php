<?php

namespace App\Api\Tokenization\Application\MintToken;

use App\Api\Auth\Domain\Repository\UserRepositoryInterface;
use App\Api\Shared\Domain\Entity\TokenTxHash;
use App\Api\Shared\Domain\Exception\NotFoundException;
use App\Api\Shared\Domain\Repository\TokenRepositoryInterface;
use App\Api\Tokenization\Domain\DataSource\TokenApiDataSource;

final readonly class MintTokenCommandHandler
{
    public function __construct(
        private TokenApiDataSource $dataSource,
        private UserRepositoryInterface $repository,
        private TokenRepositoryInterface $tokenRepository
    )
    {
    }

    /**
     * @throws NotFoundException
     */
    public function __invoke(MintTokenCommand $command): void
    {
        $user = $this->repository->findOneById($command->getUserId());
        $token = $this->tokenRepository->findById($command->getTokenId());

        if (null === $user) {
            throw new NotFoundException("User not found with ID: " . $command->getUserId());
        }

        if (null === $token) {
            throw new NotFoundException("Token not found with ID: " . $command->getTokenId());
        }

        $txHash = $this->dataSource->createToken($user->getAddress(), $command->getTokenId());
        $token->addTxHash(new TokenTxHash($txHash));
        $this->tokenRepository->save($token);
    }
}