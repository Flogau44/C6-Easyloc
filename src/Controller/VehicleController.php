<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ODM\MongoDB\DocumentManager;
use App\Document\Vehicle;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Classe VehicleController
 * Gère les opérations CRUD sur les véhicules (Vehicle) via une API REST.
 */
#[Route('/api/vehicle')]
class VehicleController extends AbstractController
{
    private DocumentManager $dm;

    /**
     * Constructeur de VehicleController
     * Injecte DocumentManager pour interagir avec MongoDB via Doctrine ODM.
     */
    public function __construct(DocumentManager $dm)
    {
        $this->dm = $dm;
    }

    /**
     * Crée un nouveau véhicule et l'enregistre dans la base MongoDB.
     *
     * @param Request $request Requête contenant les données du véhicule.
     * @return JsonResponse Réponse JSON indiquant le succès ou l'échec de la création.
     */
    #[Route('/create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Création du véhicule
        $vehicle = new Vehicle();
        $vehicle->setLicencePlate($data['licencePlate']);
        $vehicle->setKm($data['km']);
        $vehicle->setInformations($data['informations']);

        // Enregistrement dans MongoDB
        $this->dm->persist($vehicle);
        $this->dm->flush();

        return new JsonResponse(['message' => 'Vehicle created'], JsonResponse::HTTP_CREATED);
    }

    /**
     * Récupère un véhicule en fonction de son identifiant unique.
     *
     * @param string $uid Identifiant unique du véhicule.
     * @return JsonResponse Retourne les détails du véhicule ou une erreur si non trouvé.
     */
    #[Route('/get/{uid}', methods: ['GET'])]
    public function get(string $uid): JsonResponse
    {
        $vehicle = $this->dm->getRepository(Vehicle::class)->find($uid);

        if (!$vehicle) {
            return new JsonResponse(['error' => 'Vehicle not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        return new JsonResponse([
            'uid' => $vehicle->getUid(),
            'licencePlate' => $vehicle->getLicencePlate(),
            'km' => $vehicle->getKm(),
            'informations' => $vehicle->getInformations()
        ]);
    }

    /**
     * Supprime un véhicule en fonction de son identifiant unique.
     *
     * @param string $uid Identifiant unique du véhicule.
     * @return JsonResponse Message de confirmation ou erreur si le véhicule est introuvable.
     */
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