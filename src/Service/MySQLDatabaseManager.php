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

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getContractById(int $id): ?Contract
    {
        return $this->em->getRepository(Contract::class)->find($id);
    }

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

    public function updateContract(int $id, array $data): void
    {
        $contract = $this->em->getRepository(Contract::class)->find($id);
        if (!$contract) return;

        $contract->setPrice($data['price']);
        $this->em->flush();
    }

    public function deleteContract(int $id): void
    {
        $contract = $this->em->getRepository(Contract::class)->find($id);
        if (!$contract) return;

        $this->em->remove($contract);
        $this->em->flush();
    }

    public function getBillingById(int $id): ?Billing
    {
        return $this->em->getRepository(Billing::class)->find($id);
    }

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

    public function updateBilling(int $id, array $data): void
    {
        $billing = $this->em->getRepository(Billing::class)->find($id);
        if (!$billing) return;

        $billing->setAmount($data['amount']);
        $this->em->flush();
    }

    public function deleteBilling(int $id): void
    {
        $billing = $this->em->getRepository(Billing::class)->find($id);
        if (!$billing) return;

        $this->em->remove($billing);
        $this->em->flush();
    }
}