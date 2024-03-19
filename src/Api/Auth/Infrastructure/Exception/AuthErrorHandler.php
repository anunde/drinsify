<?php

namespace App\Api\Auth\Infrastructure\Exception;

use App\Api\Auth\Domain\Exception\UserAlreadyExistsException;
use App\Api\Auth\Domain\Exception\UserIsActiveException;
use App\Api\Auth\Domain\Exception\UserIsNotActivatedException;
use App\Api\Auth\Domain\Exception\UserUnauthorizedException;
use App\Api\Shared\Domain\Exception\NotFoundException;
use App\Api\Shared\Infrastructure\Exception\ErrorHandler;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthErrorHandler extends ErrorHandler
{
    public function handle(\Throwable $exception): JsonResponse
    {
        if ($exception instanceof UserAlreadyExistsException) {

            $this->statusCode = 409;
            $this->message = $exception->getMessage();

        } elseif ($exception instanceof UserIsActiveException) {

            $this->statusCode = 409;
            $this->message = $exception->getMessage();

        } elseif ($exception instanceof  UserUnauthorizedException) {

            $this->statusCode = 401;
            $this->message = $exception->getMessage();

        } elseif ($exception instanceof  UserIsNotActivatedException) {

            $this->statusCode = 403;
            $this->message = $exception->getMessage();

        }

        return parent::handle($exception);
    }
}