<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "billing")]
class Billing
{
    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    #[ORM\GeneratedValue]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Contract::class)]
    #[ORM\JoinColumn(name: "contract_id", referencedColumnName: "id", nullable: false)]
    private Contract $contract;

    #[ORM\Column(type: "decimal", precision: 10, scale: 2)]
    private float $amount;
}