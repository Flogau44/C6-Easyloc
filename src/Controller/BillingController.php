<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Billing;
use App\Entity\Contract;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/billing')]
class BillingController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $contract = $this->em->getRepository(Contract::class)->find($data['contract_id']);

        if (!$contract) {
            return new JsonResponse(['error' => 'Contract not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $billing = new Billing();
        $billing->setAmount($data['amount']);
        $billing->setContract($contract);

        $this->em->persist($billing);
        $this->em->flush();

        return new JsonResponse(['message' => 'Billing created'], JsonResponse::HTTP_CREATED);
    }

    #[Route('/get/{id}', methods: ['GET'])]
    public function get(int $id): JsonResponse
    {
        $billing = $this->em->getRepository(Billing::class)->find($id);

        if (!$billing) {
            return new JsonResponse(['error' => 'Billing not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        return new JsonResponse([
            'id' => $billing->getId(),
            'amount' => $billing->getAmount(),
            'contract_id' => $billing->getContract()->getId()
        ]);
    }

    #[Route('/delete/{id}', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $billing = $this->em->getRepository(Billing::class)->find($id);

        if (!$billing) {
            return new JsonResponse(['error' => 'Billing not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $this->em->remove($billing);
        $this->em->flush();

        return new JsonResponse(['message' => 'Billing deleted'], JsonResponse::HTTP_OK);
    }
}