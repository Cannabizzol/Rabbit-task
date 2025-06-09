<?php

namespace App\Controller;

use App\Entity\SupportRequest;
use App\Message\ManagementSupportRequestMessage;
use App\Service\SupportMessageBuilder;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\SupportQueueTester;
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
        private SupportMessageBuilder $supportMessageBuilder,
    )
    {
    }

    #[Route('/support/request', name: 'app_support_request', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $supportRequest = $this->createSupportRequest($data);
        $envelope = $this->supportMessageBuilder->build($supportRequest);

        $this->entityManager->persist($supportRequest);
        $this->entityManager->flush();

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

    #[Route('/support/test', name: 'app_support_test_queues')]
    public function testQueues(SupportQueueTester $tester): JsonResponse
    {
        $tester->sendTestMessages();

        return new JsonResponse(['status' => 'Test messages sent']);
    }
}
