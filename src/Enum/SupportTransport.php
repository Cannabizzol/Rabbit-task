<?php

namespace App\Enum;

enum SupportTransport: string
{
    case TECH = 'support_tech';
    case FINANCE = 'support_finance';
    case MANAGEMENT = 'support_management';
    case FANOUT = 'support_fanout';
}
