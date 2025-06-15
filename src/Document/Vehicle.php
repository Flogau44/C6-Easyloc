<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * Document Vehicle
 * Représente un véhicule dans la base MongoDB.
 */
#[ODM\Document]
class Vehicle
{
    #[ODM\Id(strategy: "UUID")]
    private string $uid;

    #[ODM\Field(type: "string")]
    private string $licencePlate;

    #[ODM\Field(type: "string")]
    private string $informations;

    #[ODM\Field(type: "int")]
    private int $km;

    public function getUid(): string { return $this->uid; }
    public function getLicencePlate(): string { return $this->licencePlate; }
    public function getInformations(): string { return $this->informations; }
    public function getKm(): int { return $this->km; }

    public function setLicencePlate(string $licencePlate): void
    {
        $this->licencePlate = $licencePlate;
    }

    public function setInformations(string $informations): void
    {
        $this->informations = $informations;
    }

    public function setKm(int $km): void
    {
        $this->km = $km;
    }
}