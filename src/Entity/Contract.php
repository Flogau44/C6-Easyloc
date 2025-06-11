<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "contract")]
class Contract
{
    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    #[ORM\GeneratedValue]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 255)]
    private string $vehicleUid;

    #[ORM\Column(type: "string", length: 255)]
    private string $customerUid;

    #[ORM\Column(type: "datetime")]
    private \DateTimeInterface $signDatetime;

    #[ORM\Column(type: "datetime")]
    private \DateTimeInterface $locBeginDatetime;

    #[ORM\Column(type: "datetime")]
    private \DateTimeInterface $locEndDatetime;

    #[ORM\Column(type: "datetime", nullable: true)]
    private ?\DateTimeInterface $returningDatetime = null;

    #[ORM\Column(type: "decimal", precision: 10, scale: 2)]
    private float $price;
}