<?php

namespace App\MessageHandler;

use App\Message\ManagementSupportRequestMessage;
use App\Service\SupportRequestMessageLoader;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(fromTransport: 'support_fanout')]
class LoggerHandler
{
    public function __construct(
        private LoggerInterface $logger,
        private SupportRequestMessageLoader $supportRequestMessageLoader
    )
    {
    }
    public function __invoke(ManagementSupportRequestMessage $message)
    {
        $messageFromBd = $this->supportRequestMessageLoader->load($message->requestId);
        $this->logger->info('Что-то там залогали'. $message->requestId);
    }
}
