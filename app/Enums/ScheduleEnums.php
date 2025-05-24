<?php

namespace App\Enums;

enum ScheduleEnums: string
{
    case EVERY = 'EVERY';
    case SAT = 'SAT';
    case SUN = 'SUN';
    case MON = 'MON';
    case TUE = 'TUE';
    case WED = 'WED';
    case THU = 'THU';
    case FRI = 'FRI';
}