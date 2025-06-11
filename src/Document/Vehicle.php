<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

#[MongoDB\Document]
class Vehicle
{
    #[MongoDB\Id(strategy: "UUID")]
    private string $uid;

    #[MongoDB\Field(type: "string")]
    private string $licencePlate;

    #[MongoDB\Field(type: "string")]
    private string $information;

    #[MongoDB\Field(type: "int")]
    private int $km;

    public function getUid(): string { return $this->uid; }
    public function getLicencePlate(): string { return $this->licencePlate; }
    public function getInformation(): string { return $this->information; }
    public function getKm(): int { return $this->km; }
}