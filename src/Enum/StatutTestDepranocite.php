<?php

namespace App\Enum;

/**
 * Enum StatutTestDepranocite
 *
 * Représente les statuts possibles du test de drépanocytose.
 */
enum StatutTestDepranocite: string
{
    case NOT_TESTED = 'NON TESTÉ';
    case TESTED = 'TESTÉ';
    case POSITIVE = 'DIAGNOSTIQUÉ POSITIF';
    case NEGATIVE = 'DIAGNOSTIQUÉ NÉGATIF';

    /**
     * Renvoie tous les statuts sous forme de tableau pour les choix (exemple : formulaire).
     *
     * @return string[]
     */
    public static function choices(): array
    {
        return [
            'Non testé' => self::NOT_TESTED->value,
            'Testé' => self::TESTED->value,
            'Diagnostiqué positif' => self::POSITIVE->value,
            'Diagnostiqué négatif' => self::NEGATIVE->value,
        ];
    }
}