<?php

namespace App\Entity;

use App\Repository\BillingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BillingRepository::class)]
#[ORM\Table(name: "billing")]
class Billing
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "decimal", precision: 10, scale: 2)]
    private ?float $amount = null;

    /** Relation ManyToOne avec Contract */
    #[ORM\ManyToOne(targetEntity: Contract::class, inversedBy: "billings")]
    #[ORM\JoinColumn(nullable: false)]
    private ?Contract $contract = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;
        return $this;
    }

    public function getContract(): ?Contract
    {
        return $this->contract;
    }

    public function setContract(?Contract $contract): self
    {
        $this->contract = $contract;
        return $this;
    }
}