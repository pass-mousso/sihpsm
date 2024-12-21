<?php

/**
 * Class StatutTestDepranociteDataTransformer
 *
 * This service handles subscription-related checks, such as determining whether
 * a user has an active subscription and retrieving the current subscription.
 *
 * @package App\Form\DataTransformer
 * @author Jean Mermoz Effi
 * @email jeanmermozeffi@gmail.com
 * @version 1.0
 * @created 19/12/2024
 */

namespace App\Form\DataTransformer;
use App\Enum\StatutTestDepranocite;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class StatutTestDepranociteDataTransformer implements DataTransformerInterface
{
    // Transforme une enum StatutTestDepranocite en string
    public function transform($value): ?string
    {
        if ($value instanceof StatutTestDepranocite) {
            return $value->value;
        }

        return null;
    }

    // Transforme une string en enum StatutTestDepranocite
    public function reverseTransform($value): ?StatutTestDepranocite
    {
        if (null === $value || '' === $value) {
            return null;
        }

        try {
            return StatutTestDepranocite::from($value);
        } catch (\ValueError $e) {
            // La valeur n'est pas valide
            throw new TransformationFailedException(sprintf(
                'Invalid value "%s" for StatutTestDepranocite.',
                $value
            ));
        }
    }
}