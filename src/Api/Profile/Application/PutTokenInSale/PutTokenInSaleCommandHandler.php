<?php

namespace App\Api\Profile\Application\PutTokenInSale;

use App\Api\Auth\Domain\Entity\User\User;
use App\Api\Auth\Domain\Repository\UserRepositoryInterface;
use App\Api\Shared\Domain\Entity\Token;
use App\Api\Shared\Domain\Entity\TokenPrice;
use App\Api\Shared\Domain\Exception\ConflictException;
use App\Api\Shared\Domain\Exception\NotFoundException;
use App\Api\Shared\Domain\Repository\TokenRepositoryInterface;

final readonly class PutTokenInSaleCommandHandler
{
    public function __construct(
        private TokenRepositoryInterface $repository,
        private UserRepositoryInterface $userRepository
    )
    {
    }

    /**
     * @throws NotFoundException
     * @throws ConflictException
     */
    public function __invoke(PutTokenInSaleCommand $command): void
    {
        $user = $this->getUser($command->getUserId());
        $this->validateUserHasMetamaskAddress($user);

        $token = $this->getToken($command->getTokenId());
        $this->validateTokenSaleConditions($command, $token);

        $token->putUpForSale(new TokenPrice($command->getPrice()));
        $this->repository->save($token);
    }

    /**
     * @throws NotFoundException
     */
    private function getUser(string $userId): User
    {
        if (null === $user = $this->userRepository->findOneById($userId)) {
            throw new NotFoundException('User not found');
        }
        return $user;
    }

    /**
     * @throws ConflictException
     */
    private function validateUserHasMetamaskAddress(User $user): void
    {
        if (!$user->getMetamaskAddress()) {
            throw new ConflictException("You haven't added any metamask address to receive the amount of the sale. Please, check it out in the section Profile");
        }
    }

    /**
     * @throws NotFoundException
     */
    private function getToken(string $tokenId): Token
    {
        if (null === $token = $this->repository->findById($tokenId)) {
            throw new NotFoundException('Token not found');
        }
        return $token;
    }

    /**
     * @throws ConflictException
     */
    private function validateTokenSaleConditions(PutTokenInSaleCommand $command, Token $token): void
    {
        if ($token->isRequested()) {
            throw new ConflictException('This token is requested');
        }

        if ($command->getPrice() < $token->getProduct()->getPrice()) {
            throw new ConflictException('You can not put the token up for sale cheaper than the cellar price');
        }

        if (!$token->getTokenNumber() || !$token->getExternalUrl()) {
            throw new ConflictException('This token is not yet correctly registered on the network, please wait a bit. If the problem persists you can contact us');
        }

        if ($command->getUserId() != $token->getUserId()) {
            throw new ConflictException("You aren't the owner of this Token");
        }
    }
}