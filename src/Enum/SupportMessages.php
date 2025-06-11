<?php

namespace App\Enum;


enum SupportMessages: string
{
    case TECH = \App\Message\TechSupportRequestMessage::class;
    case FINANCE = \App\Message\FinanceSupportRequestMessage::class;
    case MANAGEMENT = \App\Message\ManagementSupportRequestMessage::class;
}

