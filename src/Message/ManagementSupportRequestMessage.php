<?php

namespace App\Message;

use Symfony\Component\Messenger\Attribute\AsMessage;

#[AsMessage(transport: ['support_management'])]
class ManagementSupportRequestMessage
{
}
