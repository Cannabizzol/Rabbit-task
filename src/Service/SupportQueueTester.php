<?php

namespace App\Service;
use App\Message\ManagementSupportRequestMessage;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpStamp;
use Symfony\Component\Messenger\MessageBusInterface;

class SupportQueueTester
{
    public function __construct(private MessageBusInterface $messageBus) {}

    public function sendTestMessages(): void
    {
        $messagesData = [
            ['id' => 1, 'routingKey' => 'support..high'],
            ['id' => 2, 'routingKey' => 'support.finance.low'],
            ['id' => 3, 'routingKey' => 'support.management.medium'],
            ['id' => 4, 'routingKey' => 'support.tech.high'],  // Повтор для проверки
            ['id' => 5, 'routingKey' => 'support.finance.low'],
        ];

        foreach ($messagesData as $data) {
            $message = new ManagementSupportRequestMessage($data['id']);
            $envelope = new Envelope($message, [new AmqpStamp($data['routingKey'])]);

            $this->messageBus->dispatch($envelope);

//            echo sprintf("Отправлено сообщение с ID=%d и routingKey=%s\n", $data['id'], $data['routingKey']);
        }
    }
}
