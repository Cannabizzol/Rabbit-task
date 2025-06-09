<?php

namespace App\Service;

use App\Entity\SupportRequest;
use App\Message\FinanceSupportRequestMessage;
use App\Message\ManagementSupportRequestMessage;
use App\Message\TechSupportRequestMessage;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpStamp;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Stamp\TransportNamesStamp;

class SupportMessageBuilder
{
    private const array MESSAGES = [
        'tech' => TechSupportRequestMessage::class,
        'finance' => FinanceSupportRequestMessage::class,
        'management' => ManagementSupportRequestMessage::class,
    ];
    private const array TRANSPORTS = [
        'tech' => 'support_tech',
        'finance' => 'support_finance',
        'management' => 'support_management',
    ];

    public function build(SupportRequest $supportRequest): ?Envelope
    {
        $routingKey = sprintf(
            'support.%s.%s',
            $supportRequest->getType(),
            $supportRequest->getPriority());

        foreach (self::MESSAGES as $messageType => $class) {
            if ($messageType === $supportRequest->getType()) {
                return new Envelope(
                    new $class((string)$supportRequest->getId()),
                    [
                        new AmqpStamp($routingKey),
                        new TransportNamesStamp($this->getTransports($supportRequest->getType())),
                    ]
                );
            }

        }

        return null;
    }

    private function getTransports(string $type): array
    {
        $transports = [
            'support_fanout',
        ];
        $transports[] = self::TRANSPORTS[$type];

        return $transports;
    }
}
