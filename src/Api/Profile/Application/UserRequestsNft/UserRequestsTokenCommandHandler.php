<?php

namespace App\Api\Profile\Application\UserRequestsNft;

use App\Api\Shared\Domain\Exception\ConflictException;
use App\Api\Shared\Domain\Exception\NotFoundException;
use App\Api\Shared\Domain\Mailing\MailerDomain;
use App\Api\Shared\Domain\Service\HtmlGenerator;
use App\Api\Shared\Infrastructure\Persistence\Repository\TokenRepository;
use Doctrine\ORM\NonUniqueResultException;

final readonly class UserRequestsTokenCommandHandler
{
    public function __construct(
        private TokenRepository $repository,
        private MailerDomain $mailer,
        private HtmlGenerator $generator
    )
    {
    }

    /**
     * @throws NonUniqueResultException
     * @throws NotFoundException
     * @throws ConflictException
     */
    public function __invoke(UserRequestsTokenCommand $command): void
    {
        if(null === $token = $this->repository->findById($command->getTokenId())) {
            throw new NotFoundException(\sprintf('Token not found by ID: %s', $command->getTokenId()));
        }

        if ($token->getUserId() != $command->getUserId()) {
            throw new ConflictException('You are not the owner of this token');
        }

        $token->requestsToken();
        $this->repository->save($token);

        $payload = [
            'id' => $command->getTokenId()
        ];

        $this->mailer->send(
            $command->getReceiverEmail(),
            $command->getSubject(),
            $this->generator->generateWithPayload($command->getTemplatePath(), $payload)
        );
    }
}