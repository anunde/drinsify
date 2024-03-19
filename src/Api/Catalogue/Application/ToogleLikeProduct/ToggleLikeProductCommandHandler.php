<?php

namespace App\Api\Catalogue\Application\ToogleLikeProduct;

use App\Api\Catalogue\Domain\Entity\Like;
use App\Api\Catalogue\Domain\Repository\LikeRepositoryInterface;
use App\Api\Shared\Domain\Repository\ProductRepositoryInterface;

final readonly class ToggleLikeProductCommandHandler
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private LikeRepositoryInterface $likeRepository
    )
    {
    }

    public function __invoke(ToggleLikeProductCommand $command): void
    {
        $this->productRepository->checkProductExistOrFail($command->getProductId());

        if (null === $like = $this->likeRepository->findOneByUserIdAndProductId($command->getUserId(), $command->getProductId())) {
            $like = Like::create($command->getUserId(), $command->getProductId());
            $this->likeRepository->save($like);
        } else {
            $this->likeRepository->remove($like);
        }
    }
}