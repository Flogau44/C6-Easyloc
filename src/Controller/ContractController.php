<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Contract;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/contract')]
class ContractController extends AbstractController
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

        $contract = new Contract();
        $contract->setSignDatetime(new \DateTime());
        $contract->setLocBeginDatetime(new \DateTime($data['locBegin']));
        $contract->setLocEndDatetime(new \DateTime($data['locEnd']));
        $contract->setReturningDatetime(null);
        $contract->setPrice($data['price']);
        $contract->setCustomerUid($data['customer_uid']);
        $contract->setVehicleUid($data['vehicle_uid']);

        $this->em->persist($contract);
        $this->em->flush();

        return new JsonResponse(['message' => 'Contract created'], JsonResponse::HTTP_CREATED);
    }

    #[Route('/get/{id}', methods: ['GET'])]
    public function get(int $id): JsonResponse
    {
        $contract = $this->em->getRepository(Contract::class)->find($id);

        if (!$contract) {
            return new JsonResponse(['error' => 'Contract not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        return new JsonResponse([
            'id' => $contract->getId(),
            'price' => $contract->getPrice(),
            'customer_uid' => $contract->getCustomerUid(),
            'vehicle_uid' => $contract->getVehicleUid()
        ]);
    }

    #[Route('/delete/{id}', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $contract = $this->em->getRepository(Contract::class)->find($id);

        if (!$contract) {
            return new JsonResponse(['error' => 'Contract not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $this->em->remove($contract);
        $this->em->flush();

        return new JsonResponse(['message' => 'Contract deleted'], JsonResponse::HTTP_OK);
    }
}