<?php

namespace App\Controller;

use App\Entity\SupportRequest;
use App\Message\SupportRequestMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpStamp;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

final class SupportRequestController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private MessageBusInterface    $messageBus,
    )
    {
    }

    #[Route('/support/request', name: 'app_support_request', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $supportRequest = $this->createSupportRequest($data);

        $routingKey = sprintf(
            'support.%s.%s',
            $supportRequest->getType(),
            $supportRequest->getPriority());

        $this->entityManager->persist($supportRequest);
        $this->entityManager->flush();

        $envelope = new Envelope(
            new SupportRequestMessage((string)$supportRequest->getId()),
            [new AmqpStamp($routingKey)]
        );

        $this->messageBus->dispatch($envelope);

        return new JsonResponse(['status' => 'ok', 'id' => $supportRequest->getId()]);

    }

    private function createSupportRequest(array $data): SupportRequest
    {
        return (new SupportRequest())
            ->setType($data['type'])
            ->setPriority($data['priority'])
            ->setMessage($data['message']);
    }

}
