<?php

namespace App\Message;
use Symfony\Component\Messenger\Attribute\AsMessage;
//#[AsMessage(transport: ['support_tech', 'support_finance', 'support_management', 'support_fanout'])]
#[AsMessage]
class SupportRequestMessage
{
    public function __construct(public string $requestId){
    }

}
