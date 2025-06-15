<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Contract;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Classe ContractController
 * Gère les opérations CRUD sur les contrats (Contract) via une API REST.
 */
#[Route('/api/contract')]
class ContractController extends AbstractController
{
    private EntityManagerInterface $em;

    /**
     * Constructeur de ContractController
     * Injecte EntityManager pour interagir avec la base de données MySQL via Doctrine ORM.
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Crée un nouveau contrat et l'enregistre dans la base MySQL.
     *
     * @param Request $request Requête contenant les données du contrat.
     * @return JsonResponse Réponse JSON indiquant le succès ou l'échec de la création.
     */
    #[Route('/create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Création du contrat
        $contract = new Contract();
        $contract->setSignDatetime(new \DateTime());
        $contract->setLocBeginDatetime(new \DateTime($data['locBegin']));
        $contract->setLocEndDatetime(new \DateTime($data['locEnd']));
        
        // Vérification si returningDatetime est fourni, sinon mettre null
        $returningDatetime = isset($data['returningDatetime']) ? new \DateTime($data['returningDatetime']) : null;
        $contract->setReturningDatetime($returningDatetime);

        $contract->setPrice($data['price']);
        $contract->setCustomerUid($data['customer_uid']);
        $contract->setVehicleUid($data['vehicle_uid']);

        // Enregistrement dans la base MySQL
        $this->em->persist($contract);
        $this->em->flush();

        return new JsonResponse(['message' => 'Contract created'], JsonResponse::HTTP_CREATED);
    }

    /**
     * Récupère un contrat en fonction de son identifiant.
     *
     * @param int $id Identifiant unique du contrat.
     * @return JsonResponse Retourne les détails du contrat ou une erreur si non trouvé.
     */
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
            'vehicle_uid' => $contract->getVehicleUid(),
            'returningDatetime' => $contract->getReturningDatetime()?->format('Y-m-d H:i:s') ?? null
        ]);
    }

    /**
     * Supprime un contrat en fonction de son identifiant unique.
     *
     * @param int $id Identifiant unique du contrat.
     * @return JsonResponse Message de confirmation ou erreur si le contrat est introuvable.
     */
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