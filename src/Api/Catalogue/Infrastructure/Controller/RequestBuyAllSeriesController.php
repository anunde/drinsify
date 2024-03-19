<?php

namespace App\Api\Catalogue\Infrastructure\Controller;

use App\Api\Catalogue\Application\SendRequestBuyAllSeries\SendRequestBuyAllSeriesCommand;
use App\Api\Catalogue\Application\SendRequestBuyAllSeries\SendRequestBuyAllSeriesCommandHandler;
use App\Api\Catalogue\Infrastructure\Exception\CatalogueErrorHandle;
use App\Api\Catalogue\Infrastructure\Mailing\SubjectMapping;
use App\Api\Catalogue\Infrastructure\Mailing\TemplateMapping;
use App\Api\Shared\Infrastructure\Service\RequestService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class RequestBuyAllSeriesController extends AbstractController
{
    public function __construct(
        private readonly string                                $project_email,
        private readonly SendRequestBuyAllSeriesCommandHandler $handler,
        private readonly CatalogueErrorHandle                  $errorHandle
    )
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $this->handler->__invoke(
                new SendRequestBuyAllSeriesCommand(
                    $this->project_email,
                    RequestService::getField($request, 'userEmail'),
                    RequestService::getField($request, 'productId'),
                    RequestService::getField($request, 'productName'),
                    SubjectMapping::SUBJECT_MAP['request_series'],
                    TemplateMapping::TEMPLATE_MAP['request_series']
                )
            );

            return new JsonResponse([
               'status' => 'ok',
               'message' => 'Request sent'
            ]);
        } catch (\Throwable $th) {
            return $this->errorHandle->handle($th);
        }
    }
}