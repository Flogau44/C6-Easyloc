<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ODM\MongoDB\DocumentManager;
use App\Document\Customer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Classe CustomerController
 * Gère les opérations CRUD sur les clients (Customer) via une API REST.
 */
#[Route('/api/customer')]
class CustomerController extends AbstractController
{
    private DocumentManager $dm;

    /**
     * Constructeur de CustomerController
     * Injecte DocumentManager pour interagir avec MongoDB via Doctrine ODM.
     */
    public function __construct(DocumentManager $dm)
    {
        $this->dm = $dm;
    }

    /**
     * Crée un nouveau client et l'enregistre dans la base MongoDB.
     *
     * @param Request $request Requête contenant les données du client.
     * @return JsonResponse Réponse JSON indiquant le succès ou l'échec de la création.
     */
    #[Route('/create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Création du client
        $customer = new Customer();
        $customer->setFirstName($data['firstName']);
        $customer->setLastName($data['lastName']);
        $customer->setAddress($data['address']);
        $customer->setPermitNumber($data['permitNumber']);

        // Enregistrement dans la base MongoDB
        $this->dm->persist($customer);
        $this->dm->flush();

        return new JsonResponse(['message' => 'Customer created'], JsonResponse::HTTP_CREATED);
    }

    /**
     * Récupère un client en fonction de son identifiant unique.
     *
     * @param string $uid Identifiant unique du client.
     * @return JsonResponse Retourne les détails du client ou une erreur si non trouvé.
     */
    #[Route('/get/{uid}', methods: ['GET'])]
    public function get(string $uid): JsonResponse
    {
        $customer = $this->dm->getRepository(Customer::class)->find($uid);

        if (!$customer) {
            return new JsonResponse(['error' => 'Customer not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        return new JsonResponse([
            'uid' => $customer->getUid(),
            'firstName' => $customer->getFirstName(),
            'lastName' => $customer->getLastName(),
            'address' => $customer->getAddress(),
            'permitNumber' => $customer->getPermitNumber()
        ]);
    }

    /**
     * Supprime un client en fonction de son identifiant unique.
     *
     * @param string $uid Identifiant unique du client.
     * @return JsonResponse Message de confirmation ou erreur si le client est introuvable.
     */
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