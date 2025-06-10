<?php

namespace App\MessageHandler;

use App\Message\ManagementSupportRequestMessage;
use App\Service\SupportRequestMessageLoader;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(fromTransport: 'support_fanout')]
class TelegramBotHandler
{
    public function __construct(
        private readonly SupportRequestMessageLoader $supportRequestMessageLoader
    )
    {
    }

    public function __invoke(ManagementSupportRequestMessage $message)
    {
        $messageFromBd = $this->supportRequestMessageLoader->load($message->getRequestId());
    }
}
