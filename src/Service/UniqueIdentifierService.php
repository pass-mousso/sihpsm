<?php

/**
 * Class UniqueIdentifierService
 *
 * This service handles subscription-related checks, such as determining whether
 * a user has an active subscription and retrieving the current subscription.
 *
 * @package App\Service
 * @author Jean Mermoz Effi
 * @email jeanmermozeffi@gmail.com
 * @version 1.0
 * @created 19/12/2024
 */

namespace App\Service;
use Doctrine\ORM\EntityManagerInterface;
use Random\RandomException;

class UniqueIdentifierService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Fonction principale pour générer un identifiant unique.
     *
     * @param string $entityClass La classe de l'entité où vérifier l'unicité.
     * @param string $field Le champ à vérifier pour l'unicité.
     * @return string Un identifiant unique composé de 8 chiffres.
     * @throws RandomException
     */
    public function generateUniqueIdentifier(string $entityClass, string $field = 'uniqueIdentifier'): string
    {
        do {
            $identifier = $this->generateRandomNumber();
        } while (!$this->isIdentifierUnique($identifier, $entityClass, $field));

        return $identifier;
    }

    /**
     * Génère un identifiant aléatoire de 8 chiffres.
     *
     * @return string
     * @throws RandomException
     */
    private function generateRandomNumber(): string
    {
        return str_pad((string) random_int(0, 99999999), 8, '0', STR_PAD_LEFT);
    }

    /**
     * Vérifie si l'identifiant généré est unique dans la base de données.
     *
     * @param string $identifier L'identifiant à vérifier.
     * @param string $entityClass La classe de l'entité dans laquelle chercher.
     * @param string $field Le champ à vérifier (par défaut `uniqueIdentifier`).
     * @return bool Retourne true si l'identifiant est unique, sinon false.
     */
    private function isIdentifierUnique(string $identifier, string $entityClass, string $field = 'uniqueIdentifier'): bool
    {
        $repository = $this->entityManager->getRepository($entityClass);

        // Recherche en BD pour voir si l'identifiant existe déjà
        $result = $repository->findOneBy([$field => $identifier]);

        return $result === null; // True si aucun résultat, donc unique
    }
}