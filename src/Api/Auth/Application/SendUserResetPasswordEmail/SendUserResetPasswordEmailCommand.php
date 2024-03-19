<?php

namespace App\Api\Auth\Application\SendUserResetPasswordEmail;

use App\Api\Auth\Domain\Entity\User\UserEmail;
use App\Api\Auth\Domain\Entity\User\UserName;
use App\Api\Auth\Domain\Entity\User\UserResetPasswordToken;
use App\Api\Shared\Domain\ValueObject\Uuid;

final readonly class SendUserResetPasswordEmailCommand
{
    public function __construct(
        private string $id,
        private string $name,
        private string $email,
        private string $resetPasswordToken,
        private string $subject,
        private string $templatePath
    )
    {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getResetPasswordToken(): string
    {
        return $this->resetPasswordToken;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getTemplatePath(): string
    {
        return $this->templatePath;
    }
}