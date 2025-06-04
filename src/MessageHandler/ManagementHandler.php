<?php

namespace App\MessageHandler;

use App\Message\SupportRequestMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class ManagementHandler
{

    public function __invoke(SupportRequestMessage $message)
    {

    }

}
