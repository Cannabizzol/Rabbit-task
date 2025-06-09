<?php

namespace App\Message;

use Symfony\Component\Messenger\Attribute\AsMessage;

#[AsMessage(transport: ['support_management'])]
class ManagementSupportRequestMessage
{
    public function __construct(public string $requestId)
    {
    }

}
