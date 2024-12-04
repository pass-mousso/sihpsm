<?php

namespace App\Service\Auth;

class RoleService
{
    private array $roles = [
        // Rôles généraux
        'ROLE_USER' => 'Utilisateur standard, accès basique aux fonctionnalités',
        'ROLE_ADMIN' => 'Administrateur général, gestion complète du système',
        'ROLE_SUPER_ADMIN' => 'Super administrateur avec contrôle total du système.',
        'ROLE_DOCTOR' => 'Médecin, accès aux dossiers médicaux, prescriptions, diagnostics',
        'ROLE_NURSE' => 'Infirmier/infirmière, gestion des soins infirmiers, suivi des patients',
        'ROLE_PATIENT' => 'Patient, accès restreint à leurs propres dossiers et résultats',
        'ROLE_LAB_TECH' => 'Technicien de laboratoire, gestion des tests et résultats de laboratoire',
        'ROLE_PHARMACIST' => 'Pharmacien, gestion des prescriptions et des stocks de médicaments',
        'ROLE_RECEPTIONIST' => 'Réceptionniste, gestion des rendez-vous et de l\'accueil des patients',
        'ROLE_BILLING' => 'Gestionnaire de facturation, suivi des paiements et des factures',
        'ROLE_RADIATION_TECH' => 'Technicien en radiologie, gestion des examens d\'imagerie médicale',
        'ROLE_SURGEON' => 'Chirurgien, accès aux outils de planification des interventions chirurgicales',
        'ROLE_HR_MANAGER' => 'Responsable RH, gestion du personnel et des plannings',
        'ROLE_FINANCE_MANAGER' => 'Responsable financier, accès aux rapports financiers et à la budgétisation',
        'ROLE_IT_ADMIN' => 'Administrateur informatique, gestion des infrastructures et de la sécurité',
        'ROLE_MAINTENANCE' => 'Responsable de la maintenance, suivi des équipements et incidents techniques',
        'ROLE_SUPERVISOR' => 'Superviseur, suivi global des activités des différents départements',
        'ROLE_RESEARCHER' => 'Chercheur, accès aux données anonymisées pour études et analyses',
        'ROLE_PUBLIC_HEALTH' => 'Professionnel de santé publique, accès aux rapports statistiques et analyses',
        'ROLE_EMERGENCY' => 'Équipe d\'urgence, accès prioritaire aux dossiers des patients en situations critiques',

        // Rôles spécifiques au SaaS
        'ROLE_OWNER' => 'Propriétaire principal du compte et des abonnements.',
        'ROLE_ACCOUNT_OWNER' => 'Détenteur du compte principal et des offres associées.',
        'ROLE_SUBSCRIBER' => 'Abonné aux services ou offres.',
        'ROLE_MANAGER' => 'Gestionnaire des utilisateurs ou abonnements.',
        'ROLE_TENANT_ADMIN' => 'Administrateur principal dans une architecture multi-tenant.',
        'ROLE_PRIMARY_USER' => 'Utilisateur principal du compte.',
        'ROLE_CUSTOMER_ADMIN' => 'Administrateur du compte client.',

        // Autres rôles spécifiques (si nécessaire)
        'ROLE_TEAM_MEMBER' => 'Membre de l’équipe avec des permissions restreintes.',
        'ROLE_SUPPORT' => 'Personnel de support avec accès limité aux données des utilisateurs.',
    ];

    public function getRoleByName(string $roleName): ?string
    {
        $roles = $this->getRoles();

        return $roles[$roleName] ?? null;
    }

    /**
     * Retourne tous les rôles avec leurs descriptions.
     *
     * @return array
     */
    public function getAllRoles(): array
    {
        return $this->roles;
    }

    /**
     * Retourne la description d'un rôle donné.
     *
     * @param string $role
     * @return string|null
     */
    public function getRoleDescription(string $role): ?string
    {
        return $this->roles[$role] ?? null;
    }

    /**
     * Vérifie si un rôle est valide.
     *
     * @param string $role
     * @return bool
     */
    public function isValidRole(string $role): bool
    {
        return array_key_exists($role, $this->roles);
    }

}