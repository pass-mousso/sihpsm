<?php

namespace App\Enum;

enum PeriodTypeEnum: string
{
    case MORNING = 'matin';
    case AFTERNOON = 'après-midi';
    case EVENING = 'soir';
    case NIGHT = 'nuit';
}