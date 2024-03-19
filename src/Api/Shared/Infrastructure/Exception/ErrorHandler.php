<?php

namespace App\Api\Shared\Infrastructure\Exception;

use App\Api\Shared\Domain\Exception\ApiResponseException;
use App\Api\Shared\Domain\Exception\BadRequestException;
use App\Api\Shared\Domain\Exception\ConflictException;
use App\Api\Shared\Domain\Exception\NotFoundException;
use Symfony\Component\HttpFoundation\JsonResponse;

class ErrorHandler
{
    protected int $statusCode = 500;
    protected string $message = "An unexpected error occurred";
    public function handle(\Throwable $exception): JsonResponse
    {
        if ($exception instanceof \InvalidArgumentException) {

            $this->statusCode = 400;
            $this->message = $exception->getMessage();

        } elseif ($exception instanceof \RuntimeException){

            $this->message = 'A server error occurred';

        } elseif ($exception instanceof NotFoundException) {

            $this->statusCode = 404;
            $this->message = $exception->getMessage();

        } elseif ($exception instanceof ApiResponseException) {

            $this->statusCode = 503;
            $this->message = $exception->getMessage();

        } elseif ($exception instanceof BadRequestException) {

            $this->statusCode = 404;
            $this->message = $exception->getMessage();

        } elseif ($exception instanceof ConflictException) {

            $this->statusCode = 409;
            $this->message = $exception->getMessage();
        }

        $data = [
            'status' => 'nok',
            'code' => $exception->getCode() === 0 ? $this->statusCode : $exception->getCode(),
            'message' => $this->message
        ];

        return new JsonResponse($data, $this->statusCode);
    }
}