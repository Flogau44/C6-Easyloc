<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Contract;
use App\Entity\Billing;

/**
 * Classe MySQLDatabaseManager
 * Gère l'accès aux données SQL (Contract, Billing).
 */
class MySQLDatabaseManager implements SQLDatabaseManagerInterface
{
    private EntityManagerInterface $em;

    /**
     * Constructeur de MySQLDatabaseManager
     * Injecte l'EntityManager pour gérer la connexion et les requêtes MySQL.
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Récupère un contrat en fonction de son identifiant.
     *
     * @param int $id Identifiant du contrat.
     * @return Contract|null Retourne l'objet Contract ou null si non trouvé.
     */
    public function getContractById(int $id): ?Contract
    {
        return $this->em->getRepository(Contract::class)->find($id);
    }

    /**
     * Crée un nouveau contrat et l'enregistre dans la base MySQL.
     *
     * @param array $data Données du contrat (date début/fin, prix, client, véhicule).
     */
    public function createContract(array $data): void
    {
        $contract = new Contract();
        $contract->setSignDatetime(new \DateTime());
        $contract->setLocBeginDatetime(new \DateTime($data['locBegin']));
        $contract->setLocEndDatetime(new \DateTime($data['locEnd']));
        $contract->setPrice($data['price']);
        $contract->setCustomerUid($data['customer_uid']);
        $contract->setVehicleUid($data['vehicle_uid']);

        $this->em->persist($contract);
        $this->em->flush();
    }

    /**
     * Met à jour un contrat existant.
     *
     * @param int $id Identifiant du contrat.
     * @param array $data Nouvelles données à enregistrer.
     */
    public function updateContract(int $id, array $data): void
    {
        $contract = $this->em->getRepository(Contract::class)->find($id);
        if (!$contract) return;

        $contract->setPrice($data['price']);
        $this->em->flush();
    }

    /**
     * Supprime un contrat en fonction de son identifiant.
     *
     * @param int $id Identifiant du contrat.
     */
    public function deleteContract(int $id): void
    {
        $contract = $this->em->getRepository(Contract::class)->find($id);
        if (!$contract) return;

        $this->em->remove($contract);
        $this->em->flush();
    }

    /**
     * Récupère un paiement en fonction de son identifiant.
     *
     * @param int $id Identifiant du paiement.
     * @return Billing|null Retourne l'objet Billing ou null si non trouvé.
     */
    public function getBillingById(int $id): ?Billing
    {
        return $this->em->getRepository(Billing::class)->find($id);
    }

    /**
     * Crée un nouveau paiement et l'associe à un contrat existant.
     *
     * @param array $data Données du paiement (montant, contrat associé).
     */
    public function createBilling(array $data): void
    {
        $contract = $this->em->getRepository(Contract::class)->find($data['contract_id']);
        if (!$contract) return;

        $billing = new Billing();
        $billing->setAmount($data['amount']);
        $billing->setContract($contract);

        $this->em->persist($billing);
        $this->em->flush();
    }

    /**
     * Met à jour un paiement existant.
     *
     * @param int $id Identifiant du paiement.
     * @param array $data Nouvelles données du paiement.
     */
    public function updateBilling(int $id, array $data): void
    {
        $billing = $this->em->getRepository(Billing::class)->find($id);
        if (!$billing) return;

        $billing->setAmount($data['amount']);
        $this->em->flush();
    }

    /**
     * Supprime un paiement en fonction de son identifiant.
     *
     * @param int $id Identifiant du paiement.
     */
    public function deleteBilling(int $id): void
    {
        $billing = $this->em->getRepository(Billing::class)->find($id);
        if (!$billing) return;

        $this->em->remove($billing);
        $this->em->flush();
    }
}