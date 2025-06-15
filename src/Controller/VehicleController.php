<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ODM\MongoDB\DocumentManager;
use App\Document\Vehicle;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/vehicle')]
class VehicleController extends AbstractController
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
        $vehicle = new Vehicle();
        $vehicle->setLicencePlate($data['licencePlate']);
        $vehicle->setKm($data['km']);
        $vehicle->setInformations($data['informations']);

        $this->dm->persist($vehicle);
        $this->dm->flush();

        return new JsonResponse(['message' => 'Vehicle created'], JsonResponse::HTTP_CREATED);
    }

    #[Route('/get/{uid}', methods: ['GET'])]
    public function get(string $uid): JsonResponse
    {
        $vehicle = $this->dm->getRepository(Vehicle::class)->find($uid);

        if (!$vehicle) {
            return new JsonResponse(['error' => 'Vehicle not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        return new JsonResponse($vehicle);
    }

    #[Route('/delete/{uid}', methods: ['DELETE'])]
    public function delete(string $uid): JsonResponse
    {
        $vehicle = $this->dm->getRepository(Vehicle::class)->find($uid);

        if (!$vehicle) {
            return new JsonResponse(['error' => 'Vehicle not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $this->dm->remove($vehicle);
        $this->dm->flush();

        return new JsonResponse(['message' => 'Vehicle deleted'], JsonResponse::HTTP_OK);
    }
}