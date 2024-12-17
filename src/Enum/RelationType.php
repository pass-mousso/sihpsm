<?php

namespace App\Enum;

final class RelationType
{
    public const SPOUSE_MALE = 'Epoux';
    public const SPOUSE_FEMALE = 'Epouse';
    public const FATHER = 'Père';
    public const MOTHER = 'Mère';
    public const COUSIN_MALE = 'Cousin';
    public const COUSIN_FEMALE = 'Cousine';
    public const BROTHER = 'Frère';
    public const SISTER = 'Soeur';
    public const SISTER_IN_LAW = 'Belle-Soeur';
    public const BROTHER_IN_LAW = 'Beau-Frère';
    public const GRANDMOTHER = 'Grand-mère';
    public const GRANDFATHER = 'Grand-père';
    public const CHILD = 'Enfant';
    public const GODMOTHER = 'Marraine';
    public const GODFATHER = 'Parrain';
    public const AUNT = 'Tante';
    public const UNCLE = 'Oncle';
    public const MOTHER_IN_LAW = 'Belle-mère';
    public const FATHER_IN_LAW = 'Beau-Père';
    public const GRANDSON = 'Petit-fils';
    public const GRANDDAUGHTER = 'Petite-fille';
    public const GODCHILD = 'Filleul(e)';
    public const NEPHEW = 'Neveu';
    public const NIECE = 'Nièce';
    public const EMPLOYER = 'Employeur';
    public const FIANCE_MALE = 'Fiancé';
    public const FIANCE_FEMALE = 'Fiancée';
    public const GUARDIAN_MALE = 'Tuteur';
    public const GUARDIAN_FEMALE = 'Tutrice';

    public const TYPES = [
        self::SPOUSE_MALE,
        self::SPOUSE_FEMALE,
        self::FATHER,
        self::MOTHER,
        self::COUSIN_MALE,
        self::COUSIN_FEMALE,
        self::BROTHER,
        self::SISTER,
        self::SISTER_IN_LAW,
        self::BROTHER_IN_LAW,
        self::GRANDMOTHER,
        self::GRANDFATHER,
        self::CHILD,
        self::GODMOTHER,
        self::GODFATHER,
        self::AUNT,
        self::UNCLE,
        self::MOTHER_IN_LAW,
        self::FATHER_IN_LAW,
        self::GRANDSON,
        self::GRANDDAUGHTER,
        self::GODCHILD,
        self::NEPHEW,
        self::NIECE,
        self::EMPLOYER,
        self::FIANCE_MALE,
        self::FIANCE_FEMALE,
        self::GUARDIAN_MALE,
        self::GUARDIAN_FEMALE,
    ];
}