<?php

namespace App\MessageHandler;

use App\Message\SupportRequestMessage;
use App\Service\SupportRequestMessageLoader;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(fromTransport: 'support_finance')]
class FinanceHandler
{

    public function __construct(
        private SupportRequestMessageLoader $supportRequestMessageLoader
    )
    {
    }

    public function __invoke(SupportRequestMessage $message)
    {
        $messageFromBd = $this->supportRequestMessageLoader->load($message->requestId);
    }

}
