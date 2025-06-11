<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

#[MongoDB\Document]
class Customer
{
    #[MongoDB\Id(strategy: "UUID")]
    private string $uid;

    #[MongoDB\Field(type: "string")]
    private string $firstName;

    #[MongoDB\Field(type: "string")]
    private string $secondName;

    #[MongoDB\Field(type: "string")]
    private string $address;

    #[MongoDB\Field(type: "string")]
    private string $permitNumber;

    public function getUid(): string { return $this->uid; }
    public function getFirstName(): string { return $this->firstName; }
    public function getSecondName(): string { return $this->secondName; }
    public function getAddress(): string { return $this->address; }
    public function getPermitNumber(): string { return $this->permitNumber; }
}