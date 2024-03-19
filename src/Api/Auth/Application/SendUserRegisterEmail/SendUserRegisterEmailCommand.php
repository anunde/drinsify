<?php

namespace App\Api\Auth\Application\SendUserRegisterEmail;

final readonly class SendUserRegisterEmailCommand
{
    public function __construct(
        private string $id,
        private string $email,
        private string $name,
        private string $token,
        private string $subject,
        private string $templatePath
    )
    {
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @return string
     */
    public function getTemplatePath(): string
    {
        return $this->templatePath;
    }

}