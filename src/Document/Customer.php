<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * Document Customer
 * Représente un client dans la base MongoDB.
 */
#[ODM\Document]
class Customer
{
    #[ODM\Id]
    private string $uid;

    #[ODM\Field(type: "string")]
    private string $firstName;

    #[ODM\Field(type: "string")]
    private string $lastName;

    #[ODM\Field(type: "string")]
    private string $address;

    #[ODM\Field(type: "string")]
    private string $permitNumber;

    /**
     * Récupère l'UID du client.
     * @return string
     */
    public function getUid(): string
    {
        return $this->uid;
    }

    /**
     * Récupère le prénom du client.
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * Récupère le nom du client.
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * Récupère l'adresse du client.
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * Récupère le numéro de permis du client.
     * @return string
     */
    public function getPermitNumber(): string
    {
        return $this->permitNumber;
    }

    /**
     * Définit le prénom du client.
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * Définit le nom du client.
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * Définit l'adresse du client.
     * @param string $address
     */
    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    /**
     * Définit le numéro de permis du client.
     * @param string $permitNumber
     */
    public function setPermitNumber(string $permitNumber): void
    {
        $this->permitNumber = $permitNumber;
    }
}