<?php

namespace App\Enum;

enum FrequencyType: string
{
    case HOURLY = 'heure';
    case DAILY = 'jour';
    case WEEKLY = 'semaine';
    case MONTHLY = 'mois';
}