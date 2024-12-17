<?php

namespace App\Enum;

enum UnitTypeEnum: string
{
    case MILLIGRAM = 'mg';               // Milligramme
    case MICROGRAM = 'mcg';             // Microgramme ou µg
    case GRAM = 'g';                    // Gramme
    case MILLILITER = 'ml';             // Millilitre
    case INTERNATIONAL_UNIT = 'UI';     // Unité internationale
    case PILL = 'comp';                 // Comprimé
    case CAPSULE = 'gél';               // Gélule
    case TEASPOON = 'c. à café';        // Cuillère à café
    case TABLESPOON = 'c. à soupe';     // Cuillère à soupe
    case DROP = 'goutte';               // Goutte
    case SPRAY = 'spray';               // Spray
    case PATCH = 'patch';               // Patch
    case INHALER = 'inhal';             // Inhalateur
    case SUPPOSITORY = 'suppo';         // Suppositoire
    case AMPULE = 'amp';                // Ampoule
    case BOTTLE = 'fl';                 // Flacon
    case SYRINGE = 'ser';               // Seringue

}