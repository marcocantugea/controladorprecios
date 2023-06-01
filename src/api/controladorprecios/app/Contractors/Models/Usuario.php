<?php

namespace App\Contractors\Models;

use DateTime;

class Usuario 
{
    public ?int $id;
    public ?string $publicId;
    public string $user;
    public ?string $hash;
    public ?string $email;
    public bool $active;
    public ?DateTime $created_at;
    public ?DateTime $updated_at;
    public ?DateTime $deleted_at;

    public function __construct(string $user, int $id=null, string $publicId=null, string $hash = null,string $email=null,bool $active=false,$created_at=null,$updated_at=null,$deleted_at=null) {
        $this->user=$user;
        $this->id=$id;
        $this->publicId=$publicId;
        $this->hash=$hash;
        $this->email=$email;
        $this->active=$active;
        $this->created_at=$this->setDateTime($created_at);
        $this->updated_at=$this->setDateTime($updated_at);
        $this->deleted_at= $this->setDateTime($deleted_at);

    }

    private function setDateTime($dateItem){
        if($dateItem==null) return null;
        if(is_string($dateItem)) return new DateTime($dateItem);
        if($dateItem instanceof DateTime) return $dateItem;
        return null;
    }

}
