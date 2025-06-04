<?php

namespace App\MessageHandler;

use App\Message\SupportRequestMessage;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class LoggerHandler
{
    public function __construct(
        private LoggerInterface $logger)
    {
    }

    public function __invoke(SupportRequestMessage $message)
    {
        $this->logger->info('Что-то там залогали'. $message->requestId);
    }
}
