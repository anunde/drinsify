<?php

namespace App\Api\Panel\Infrastructure\Controller;

use App\Api\Panel\Application\CreateProduct\CreateProductCommand;
use App\Api\Panel\Application\CreateProduct\CreateProductCommandHandler;
use App\Api\Panel\Infrastructure\Exception\PanelErrorHandler;
use App\Api\Shared\Infrastructure\Service\RequestService;
use App\Api\Shared\Infrastructure\Service\S3Uploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CreateProductController extends AbstractController
{
    public function __construct(
        private readonly PanelErrorHandler $errorHandler,
        private readonly CreateProductCommandHandler $handler,
        private readonly S3Uploader $uploader
    )
    {
    }

    #[Route(path: '/panel/create/token', name: 'panel_create_token', methods: 'POST')]
    public function __invoke($userId, Request $request): JsonResponse
    {
        try {
            $thumbnail = $request->files->get('thumbnail');
            $image = $request->files->get('image');
            $dataSheet = $request->files->get('dataSheet');
            $awards = $request->files->get('awards');
            $existenceProof = $request->files->get('existenceProof');
            $qr = $request->files->get('qr');

            $this->handler->__invoke(
                new CreateProductCommand(
                    $request->get('originId'),
                    $request->get('denominationId'),
                    $request->get('brandId'),
                    $request->get('cellarId'),
                    $request->get('name'),
                    $request->get('description'),
                    $this->uploader->upload($thumbnail, 'drinksify/images'),
                    $request->get('quantity'),
                    $request->get('status'),
                    $request->get('price'),
                    $request->get('taxes'),
                    $request->get('countriesAvailable'),
                    $request->get('features'),
                    $this->uploader->upload($image, 'drinksify/images'),
                    $this->uploader->upload($dataSheet, 'drinksify/files'),
                    $this->uploader->upload($awards, 'drinksify/files'),
                    $this->uploader->upload($existenceProof, 'drinksify/files'),
                    $request->get('daysDelivery'),
                    $this->uploader->upload($qr, 'drinksify/images'),
                    $request->get('requestDate')
                )
            );

            return new JsonResponse([
                'status' => 'ok',
                'message' => 'Product created!'
            ]);
        } catch (\Throwable $th) {
            return $this->errorHandler->handle($th);
        }
    }
}