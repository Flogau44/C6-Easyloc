<?php

namespace App\Service;

use App\Repository\ContractRepository;

class ContractService
{
    public function __construct(private ContractRepository $contractRepo) {}

    public function getLateContracts(): array
    {
        return $this->contractRepo->findLateContracts();
    }
}