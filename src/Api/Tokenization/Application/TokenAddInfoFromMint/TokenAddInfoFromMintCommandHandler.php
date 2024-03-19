<?php

namespace App\Api\Tokenization\Application\TokenAddInfoFromMint;

use App\Api\Shared\Domain\Entity\TokenExternalUrl;
use App\Api\Shared\Domain\Entity\TokenNumber;
use App\Api\Shared\Domain\Exception\NotFoundException;
use App\Api\Shared\Infrastructure\Persistence\Repository\TokenRepository;
use App\Api\Tokenization\Domain\DataSource\TokenApiDataSource;
use Doctrine\ORM\NonUniqueResultException;

final readonly class TokenAddInfoFromMintCommandHandler
{
    public function __construct(
        private TokenRepository $repository,
        private TokenApiDataSource $dataSource
    )
    {
    }

    /**
     * @throws NonUniqueResultException
     * @throws NotFoundException
     */
    public function __invoke(TokenAddInfoFromMintCommand $command): void
    {
        if (null === $token = $this->repository->findById($command->getTokenId())) {
            throw new NotFoundException(\sprintf('Token not found by ID: %s', $command->getTokenId()));
        }

        $externalUri = $this->dataSource->getTokenUri($command->getTokenNumber());

        $token->addTokenInfo(
            new TokenNumber($command->getTokenNumber()),
            new TokenExternalUrl($externalUri)
        );

        $this->repository->save($token);
    }
}