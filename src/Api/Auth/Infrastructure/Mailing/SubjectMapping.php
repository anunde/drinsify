<?php

namespace App\Api\Auth\Infrastructure\Mailing;

abstract class SubjectMapping
{
    public const SUBJECT_MAP = [
        'register' => '¡Bienvenid@!',
        'request_reset_password' => 'Restablecer contraseña'
    ];
}