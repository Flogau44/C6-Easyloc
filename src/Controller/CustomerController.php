<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ODM\MongoDB\DocumentManager;
use App\Document\Customer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/customer')]
class CustomerController extends AbstractController
{
    private DocumentManager $dm;

    public function __construct(DocumentManager $dm)
    {
        $this->dm = $dm;
    }

    #[Route('/create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $customer = new Customer();
        $customer->setFirstName($data['firstName']);
        $customer->setLastName($data['lastName']);
        $customer->setAddress($data['address']);
        $customer->setPermitNumber($data['permitNumber']);

        $this->dm->persist($customer);
        $this->dm->flush();

        return new JsonResponse(['message' => 'Customer created'], JsonResponse::HTTP_CREATED);
    }

    #[Route('/get/{uid}', methods: ['GET'])]
    public function get(string $uid): JsonResponse
    {
        $customer = $this->dm->getRepository(Customer::class)->find($uid);

        if (!$customer) {
            return new JsonResponse(['error' => 'Customer not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        return new JsonResponse($customer);
    }

    #[Route('/delete/{uid}', methods: ['DELETE'])]
    public function delete(string $uid): JsonResponse
    {
        $customer = $this->dm->getRepository(Customer::class)->find($uid);

        if (!$customer) {
            return new JsonResponse(['error' => 'Customer not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $this->dm->remove($customer);
        $this->dm->flush();

        return new JsonResponse(['message' => 'Customer deleted'], JsonResponse::HTTP_OK);
    }
}