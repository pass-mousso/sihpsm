<?php

/**
 * Class AllergyType
 *
 * This service handles subscription-related checks, such as determining whether
 * a user has an active subscription and retrieving the current subscription.
 *
 * @package App\Enum
 * @author Jean Mermoz Effi
 * @email jeanmermozeffi@gmail.com
 * @version 1.0
 * @created 17/12/2024
 */

namespace App\Enum;
class AllergyType
{
    public const FOOD = 'Allergie Alimentaire'; // Ex. : Noix, fruits de mer
    public const MEDICATION = 'Allergie Médicamenteuse'; // Ex. : Pénicilline
    public const ENVIRONMENTAL = 'Allergie Environnementale'; // Ex. : Pollen
    public const INSECT = 'Allergie aux Insectes'; // Ex. : Piqûres d'abeilles
    public const ANIMAL = 'Allergie Animale'; // Ex. : Poils de chat, de chien
    public const CHEMICAL = 'Allergie Chimique'; // Ex. : Produits de nettoyage
    public const OTHER = 'Autre'; // Non spécifié dans les catégories ci-dessus

    public const TYPES = [
        self::FOOD,
        self::MEDICATION,
        self::ENVIRONMENTAL,
        self::INSECT,
        self::ANIMAL,
        self::CHEMICAL,
        self::OTHER,
    ];
}