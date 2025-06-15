<?php

namespace App\Entity;

use App\Repository\ContractRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContractRepository::class)]
class Contract
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTime $sign_datetime = null;

    #[ORM\Column]
    private ?\DateTime $loc_begin_datetime = null;

    #[ORM\Column]
    private ?\DateTime $loc_end_datetime = null;

    #[ORM\Column(type: "datetime", nullable: true)]
    private ?\DateTime $returning_datetime = null;

    #[ORM\Column(length: 255)]
    private ?string $price = null;

    /** Relation vers Vehicle (MongoDB) */
    #[ORM\Column(type: "string", length: 255)]
    private string $vehicleUid;

    /** Relation vers Customer (MongoDB) */
    #[ORM\Column(type: "string", length: 255)]
    private string $customerUid;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSignDatetime(): ?\DateTime
    {
        return $this->sign_datetime;
    }

    public function setSignDatetime(\DateTime $sign_datetime): static
    {
        $this->sign_datetime = $sign_datetime;

        return $this;
    }

    public function getLocBeginDatetime(): ?\DateTime
    {
        return $this->loc_begin_datetime;
    }

    public function setLocBeginDatetime(\DateTime $loc_begin_datetime): static
    {
        $this->loc_begin_datetime = $loc_begin_datetime;

        return $this;
    }

    public function getLocEndDatetime(): ?\DateTime
    {
        return $this->loc_end_datetime;
    }

    public function setLocEndDatetime(\DateTime $loc_end_datetime): static
    {
        $this->loc_end_datetime = $loc_end_datetime;

        return $this;
    }

    public function getReturningDatetime(): ?\DateTime
    {
        return $this->returning_datetime;
    }

    public function setReturningDatetime(\DateTime $returning_datetime): static
    {
        $this->returning_datetime = $returning_datetime;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getVehicleUid(): string
    {
        return $this->vehicleUid;
    }

    public function setVehicleUid(string $vehicleUid): self
    {
        $this->vehicleUid = $vehicleUid;
        return $this;
    }

    public function getCustomerUid(): string
    {
        return $this->customerUid;
    }

    public function setCustomerUid(string $customerUid): self
    {
        $this->customerUid = $customerUid;
        return $this;
    }
}
