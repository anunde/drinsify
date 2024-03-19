<?php

namespace App\Api\Checkout\Infrastructure\Mailing;

abstract class SubjectMapping
{
    public const SUBJECT_MAPPING = [
        'purchase' => '¡Has realizado una compra en Drinksify!'
    ];
}