<?php

namespace App\Service;

use App\Entity\SupportRequest;
use App\Repository\SupportRequestRepository;
use Doctrine\ORM\EntityManagerInterface;

class SupportRequestMessageLoader
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private SupportRequestRepository $supportRequestRepository,
    )
    {
    }

    public function load(string $id): SupportRequest
    {
        return $this->supportRequestRepository->find($id);
    }
}
