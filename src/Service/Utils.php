<?php

namespace App\Service;


use App\Enum\UnitTypeEnum;
use App\Enum\UnitTypeEnumEnum;
use Random\RandomException;
use Symfony\Component\Validator\Exception\InvalidOptionsException;

class Utils
{
    /**
     * Génère un identifiant unique.
     *
     * @param int $length Longueur de l'identifiant à générer.
     * @param string $type Type de caractères à inclure ('numeric', 'alpha', 'alphanumeric', 'special', 'password').
     * @return string Identifiant généré.
     * @throws InvalidOptionsException Si les paramètres sont invalides.
     * @throws RandomException
     */
    function generateUniqueId(int $length = 8, string $type = 'numeric'): string
    {
        if ($length <= 0) {
            throw new \LogicException('La longueur doit être supérieure à 0.');
        }

        // Définition des ensembles de caractères selon le type
        $charSets = [
            'numeric' => '0123456789',
            'alpha' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
            'alphanumeric' => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
            'special' => '!@#$&*_-+=<>?',
            'password' => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$&*_-?'
        ];

        // Vérification du type valide
        if (!isset($charSets[$type])) {
            throw new InvalidOptionsException(
                "Type invalide. Utilisez 'numeric', 'alpha', 'alphanumeric', 'special' ou 'password'.",
                ['invalid_type' => $type]
            );
        }

        $characters = $charSets[$type];
        $charactersLength = strlen($characters);
        $uniqueId = '';

        // Génération de l'identifiant
        for ($i = 0; $i < $length; $i++) {
            $uniqueId .= $characters[random_int(0, $charactersLength - 1)];
        }

        return $uniqueId;
    }

    function getReadableUnit(UnitTypeEnum $unitType): string
    {
        return match ($unitType) {
            UnitTypeEnum::MILLIGRAM => 'Milligramme',
            UnitTypeEnum::MICROGRAM => 'Microgramme',
            UnitTypeEnum::GRAM => 'Gramme',
            UnitTypeEnum::MILLILITER => 'Millilitre',
            UnitTypeEnum::INTERNATIONAL_UNIT => 'Unité internationale',
            UnitTypeEnum::PILL => 'Comprimé',
            UnitTypeEnum::CAPSULE => 'Gélule',
            UnitTypeEnum::TEASPOON => 'Cuillère à café',
            UnitTypeEnum::TABLESPOON => 'Cuillère à soupe',
            UnitTypeEnum::DROP => 'Goutte',
            UnitTypeEnum::SPRAY => 'Spray',
            UnitTypeEnum::PATCH => 'Patch',
            UnitTypeEnum::INHALER => 'Inhalateur',
            UnitTypeEnum::SUPPOSITORY => 'Suppositoire',
            UnitTypeEnum::AMPULE => 'Ampoule',
            UnitTypeEnum::BOTTLE => 'Flacon',
            UnitTypeEnum::SYRINGE => 'Seringue',
        };
    }

}