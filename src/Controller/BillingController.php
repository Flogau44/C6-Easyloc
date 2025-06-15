<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Billing;
use App\Entity\Contract;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Classe BillingController
 * Gère les opérations CRUD sur les paiements (Billing) via une API REST.
 */
#[Route('/api/billing')]
class BillingController extends AbstractController
{
    private EntityManagerInterface $em;

    /**
     * Constructeur de BillingController
     * Injecte EntityManager pour interagir avec la base de données MySQL via Doctrine ORM.
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Crée un nouveau paiement et l'associe à un contrat existant.
     *
     * @param Request $request Requête contenant les données du paiement.
     * @return JsonResponse Réponse JSON indiquant le succès ou l'échec de la création.
     */
    #[Route('/create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Vérification de l'existence du contrat associé
        $contract = $this->em->getRepository(Contract::class)->find($data['contract_id']);
        if (!$contract) {
            return new JsonResponse(['error' => 'Contract not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        // Création du paiement
        $billing = new Billing();
        $billing->setAmount($data['amount']);
        $billing->setContract($contract);

        // Enregistrement dans la base
        $this->em->persist($billing);
        $this->em->flush();

        return new JsonResponse(['message' => 'Billing created'], JsonResponse::HTTP_CREATED);
    }

    /**
     * Récupère un paiement en fonction de son identifiant.
     *
     * @param int $id Identifiant du paiement.
     * @return JsonResponse Retourne les détails du paiement ou une erreur si non trouvé.
     */
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

    /**
     * Supprime un paiement en fonction de son identifiant.
     *
     * @param int $id Identifiant du paiement.
     * @return JsonResponse Message de confirmation ou erreur si le paiement est introuvable.
     */
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