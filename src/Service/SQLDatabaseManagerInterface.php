<?php

namespace App\Service;

use App\Entity\Contract;
use App\Entity\Billing;

/**
 * Interface SQLDatabaseManagerInterface
 * Définit les méthodes requises pour interagir avec la base MySQL.
 */
interface SQLDatabaseManagerInterface
{
    /**
     * Récupère un contrat en fonction de son identifiant.
     *
     * @param int $id Identifiant du contrat.
     * @return Contract|null Retourne un objet Contract ou null si non trouvé.
     */
    public function getContractById(int $id): ?Contract;

    /**
     * Crée un nouveau contrat et l'enregistre dans la base MySQL.
     *
     * @param array $data Données du contrat (dates, prix, client, véhicule).
     */
    public function createContract(array $data): void;

    /**
     * Met à jour un contrat existant.
     *
     * @param int $id Identifiant du contrat.
     * @param array $data Nouvelles données du contrat.
     */
    public function updateContract(int $id, array $data): void;

    /**
     * Supprime un contrat en fonction de son identifiant.
     *
     * @param int $id Identifiant du contrat.
     */
    public function deleteContract(int $id): void;

    /**
     * Récupère un paiement en fonction de son identifiant.
     *
     * @param int $id Identifiant du paiement.
     * @return Billing|null Retourne un objet Billing ou null si non trouvé.
     */
    public function getBillingById(int $id): ?Billing;

    /**
     * Crée un nouveau paiement et l'enregistre dans la base MySQL.
     *
     * @param array $data Données du paiement (montant, contrat associé).
     */
    public function createBilling(array $data): void;

    /**
     * Met à jour un paiement existant.
     *
     * @param int $id Identifiant du paiement.
     * @param array $data Nouvelles données du paiement.
     */
    public function updateBilling(int $id, array $data): void;

    /**
     * Supprime un paiement en fonction de son identifiant.
     *
     * @param int $id Identifiant du paiement.
     */
    public function deleteBilling(int $id): void;
}