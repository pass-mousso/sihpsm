<?php

/**
 * Class StatutTestDepranocite
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
class StatutTestDepranocite
{
    public const VALUES = [
        'NOT_TESTED' => 'NON TESTÉ',
        'TESTED' => 'TESTÉ',
        'POSITIVE' => 'DIAGNOSTIQUÉ POSITIF',
        'NEGATIVE' => 'DIAGNOSTIQUÉ NÉGATIF',
    ];
}