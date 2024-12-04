<?php

namespace App\Constant;

class Roles
{
    // Rôles de base du système de gestion des utilisateurs
    const ROLE_USER = 'ROLE_USER'; // 'Utilisateur standard, accès basique aux fonctionnalités'
    const ROLE_ADMIN = 'ROLE_ADMIN'; // 'Administrateur général, gestion complète du système'
    const ROLE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN'; // 'Super administrateur avec contrôle total du système.'
    const ROLE_DOCTOR = 'ROLE_DOCTOR'; // 'Médecin, accès aux dossiers médicaux, prescriptions, diagnostics'
    const ROLE_NURSE = 'ROLE_NURSE'; // 'Infirmier/infirmière, gestion des soins infirmiers, suivi des patients'
    const ROLE_PATIENT = 'ROLE_PATIENT'; // 'Patient, accès restreint à leurs propres dossiers et résultats'
    const ROLE_LAB_TECH = 'ROLE_LAB_TECH'; // 'Technicien de laboratoire, gestion des tests et résultats de laboratoire'
    const ROLE_PHARMACIST = 'ROLE_PHARMACIST'; // 'Pharmacien, gestion des prescriptions et des stocks de médicaments'
    const ROLE_RECEPTIONIST = 'ROLE_RECEPTIONIST'; // 'Réceptionniste, gestion des rendez-vous et de l\'accueil des patients'
    const ROLE_BILLING = 'ROLE_BILLING'; // 'Gestionnaire de facturation, suivi des paiements et des factures'
    const ROLE_RADIATION_TECH = 'ROLE_RADIATION_TECH'; // 'Technicien en radiologie, gestion des examens d\'imagerie médicale'
    const ROLE_SURGEON = 'ROLE_SURGEON'; // 'Chirurgien, accès aux outils de planification des interventions chirurgicales'
    const ROLE_HR_MANAGER = 'ROLE_HR_MANAGER'; // 'Responsable RH, gestion du personnel et des plannings'
    const ROLE_FINANCE_MANAGER = 'ROLE_FINANCE_MANAGER'; // 'Responsable financier, accès aux rapports financiers et à la budgétisation'
    const ROLE_IT_ADMIN = 'ROLE_IT_ADMIN'; // 'Administrateur informatique, gestion des infrastructures et de la sécurité'
    const ROLE_MAINTENANCE = 'ROLE_MAINTENANCE'; // 'Responsable de la maintenance, suivi des équipements et incidents techniques'
    const ROLE_SUPERVISOR = 'ROLE_SUPERVISOR'; // 'Superviseur, suivi global des activités des différents départements'
    const ROLE_RESEARCHER = 'ROLE_RESEARCHER'; // 'Chercheur, accès aux données anonymisées pour études et analyses'
    const ROLE_PUBLIC_HEALTH = 'ROLE_PUBLIC_HEALTH'; // 'Professionnel de santé publique, accès aux rapports statistiques et analyses'
    const ROLE_EMERGENCY = 'ROLE_EMERGENCY'; // 'Équipe d\'urgence, accès prioritaire aux dossiers des patients en situations critiques'

    // Rôles spécifiques au SaaS
    const ROLE_OWNER = 'ROLE_OWNER'; // 'Propriétaire principal du compte et des abonnements.'
    const ROLE_ACCOUNT_OWNER = 'ROLE_ACCOUNT_OWNER'; // 'Détenteur du compte principal et des offres associées.'
    const ROLE_SUBSCRIBER = 'ROLE_SUBSCRIBER'; // 'Abonné aux services ou offres.'
    const ROLE_MANAGER = 'ROLE_MANAGER'; // 'Gestionnaire des utilisateurs ou abonnements.'
    const ROLE_TENANT_ADMIN = 'ROLE_TENANT_ADMIN'; // 'Administrateur principal dans une architecture multi-tenant.'
    const ROLE_PRIMARY_USER = 'ROLE_PRIMARY_USER'; // 'Utilisateur principal du compte.'
    const ROLE_CUSTOMER_ADMIN = 'ROLE_CUSTOMER_ADMIN'; // 'Administrateur du compte client.'

    // Autres rôles spécifiques (si nécessaire)
    const ROLE_TEAM_MEMBER = 'ROLE_TEAM_MEMBER'; // 'Membre de l’équipe avec des permissions restreintes.'
    const ROLE_SUPPORT = 'ROLE_SUPPORT'; // 'Personnel de support avec accès limité aux données des utilisateurs.'

    // Retourne la description des rôles
    public static function getRoleDescription($role): string
    {
        $descriptions = [
            self::ROLE_USER => 'Utilisateur standard, accès basique aux fonctionnalités',
            self::ROLE_ADMIN => 'Administrateur général, gestion complète du système',
            self::ROLE_SUPER_ADMIN => 'Super administrateur avec contrôle total du système.',
            self::ROLE_DOCTOR => 'Médecin, accès aux dossiers médicaux, prescriptions, diagnostics',
            self::ROLE_NURSE => 'Infirmier/infirmière, gestion des soins infirmiers, suivi des patients',
            self::ROLE_PATIENT => 'Patient, accès restreint à leurs propres dossiers et résultats',
            self::ROLE_LAB_TECH => 'Technicien de laboratoire, gestion des tests et résultats de laboratoire',
            self::ROLE_PHARMACIST => 'Pharmacien, gestion des prescriptions et des stocks de médicaments',
            self::ROLE_RECEPTIONIST => 'Réceptionniste, gestion des rendez-vous et de l\'accueil des patients',
            self::ROLE_BILLING => 'Gestionnaire de facturation, suivi des paiements et des factures',
            self::ROLE_RADIATION_TECH => 'Technicien en radiologie, gestion des examens d\'imagerie médicale',
            self::ROLE_SURGEON => 'Chirurgien, accès aux outils de planification des interventions chirurgicales',
            self::ROLE_HR_MANAGER => 'Responsable RH, gestion du personnel et des plannings',
            self::ROLE_FINANCE_MANAGER => 'Responsable financier, accès aux rapports financiers et à la budgétisation',
            self::ROLE_IT_ADMIN => 'Administrateur informatique, gestion des infrastructures et de la sécurité',
            self::ROLE_MAINTENANCE => 'Responsable de la maintenance, suivi des équipements et incidents techniques',
            self::ROLE_SUPERVISOR => 'Superviseur, suivi global des activités des différents départements',
            self::ROLE_RESEARCHER => 'Chercheur, accès aux données anonymisées pour études et analyses',
            self::ROLE_PUBLIC_HEALTH => 'Professionnel de santé publique, accès aux rapports statistiques et analyses',
            self::ROLE_EMERGENCY => 'Équipe d\'urgence, accès prioritaire aux dossiers des patients en situations critiques',
            self::ROLE_OWNER => 'Propriétaire principal du compte et des abonnements.',
            self::ROLE_ACCOUNT_OWNER => 'Détenteur du compte principal et des offres associées.',
            self::ROLE_SUBSCRIBER => 'Abonné aux services ou offres.',
            self::ROLE_MANAGER => 'Gestionnaire des utilisateurs ou abonnements.',
            self::ROLE_TENANT_ADMIN => 'Administrateur principal dans une architecture multi-tenant.',
            self::ROLE_PRIMARY_USER => 'Utilisateur principal du compte.',
            self::ROLE_CUSTOMER_ADMIN => 'Administrateur du compte client.',
            self::ROLE_TEAM_MEMBER => 'Membre de l’équipe avec des permissions restreintes.',
            self::ROLE_SUPPORT => 'Personnel de support avec accès limité aux données des utilisateurs.',
        ];

        return $descriptions[$role] ?? 'Rôle inconnu';
    }
}
