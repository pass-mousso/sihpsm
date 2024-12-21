<?php

namespace App\Enum;

enum MaritalStatusEnum: string
{
    case SINGLE = 'single';
    case MARRIED = 'married';
    case DIVORCED = 'divorced';
    case WIDOWED = 'widowed';
    case SEPARATED = 'separated';
    case PARTNERSHIP = 'partnership';

    public static function readableChoices(): array
    {
        return [
            'Célibataire' => self::SINGLE->value,
            'Marié(e)' => self::MARRIED->value,
            'Divorcé(e)' => self::DIVORCED->value,
            'Veuf(ve)' => self::WIDOWED->value,
            'Séparé(e)' => self::SEPARATED->value,
            'En partenariat' => self::PARTNERSHIP->value,
        ];
    }
}