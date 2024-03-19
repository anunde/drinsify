<?php

namespace App\Api\Panel\Application\CreateProduct;

use App\Api\Catalogue\Domain\Entity\ProductInfo;
use App\Api\Shared\Domain\Entity\Product;
use App\Api\Shared\Domain\Repository\ProductRepositoryInterface;

final readonly class CreateProductCommandHandler
{
    public function __construct(
        private ProductRepositoryInterface $repository
    )
    {
    }

    public function __invoke(CreateProductCommand $command): void
    {
        $product = Product::create(
            $command->getOriginId(),
            $command->getDenominationId(),
            $command->getBrandId(),
            $command->getCellarId(),
            $command->getName(),
            $command->getDescription(),
            $command->getThumbnail(),
            $command->getQuantity(),
            $command->getStatus(),
            $command->getPrice(),
            $command->getTaxes(),
            $command->getCountriesAvailable()
        );

        $productInfo = ProductInfo::create(
            $product->getId(),
            $command->getFeatures(),
            $command->getImage(),
            $command->getDataSheet(),
            $command->getAwards(),
            $command->getExistenceProof(),
            $command->getDaysDelivery(),
            $command->getQr(),
            $command->getRequestDate()
        );

        $product->setProductInfo($productInfo);
        $this->repository->save($product);
    }
}