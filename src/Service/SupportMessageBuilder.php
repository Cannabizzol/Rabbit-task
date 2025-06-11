<?php

namespace App\Service;

use App\Entity\SupportRequest;
use App\Enum\SupportMessages;
use App\Enum\SupportTransport;
use App\Message\FinanceSupportRequestMessage;
use App\Message\ManagementSupportRequestMessage;
use App\Message\TechSupportRequestMessage;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpStamp;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Stamp\TransportNamesStamp;

class SupportMessageBuilder
{
    public function build(SupportRequest $supportRequest): ?Envelope
    {
        $messageEnum = match ($supportRequest->getType()) {
            'tech' => SupportMessages::TECH,
            'finance' => SupportMessages::FINANCE,
            'management' => SupportMessages::MANAGEMENT,
        };
        if ($messageEnum === null) {
            return null;
        }

        $routingKey = sprintf(
            'support.%s.%s',
            $supportRequest->getType(),
            $supportRequest->getPriority());

        return new Envelope(
            new $messageEnum->value((string)$supportRequest->getId()),
            [
                new AmqpStamp($routingKey),
                new TransportNamesStamp($this->getTransports($supportRequest->getType())),
            ]);

    }

    private function getTransports(string $type): array
    {
        $map = [
            'tech' => SupportTransport::TECH,
            'finance' => SupportTransport::FINANCE,
            'management' => SupportTransport::MANAGEMENT,
        ];

        $transports = [SupportTransport::FANOUT->value];
        if (isset($map[$type])) {
            $transports[] = $map[$type]->value;
        }

        return $transports;
    }
}
