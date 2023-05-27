<?php

namespace App\Contractors\Models;

use DateTime;

class Marca 
{
    public ?int $id;
    public ?string $publicId;
    public string $marca;
    public bool $activo=true;
    public ?DateTime $created_at;
    public ?DateTime $updated_at;
    public ?DateTime $fecha_eliminado;

    public function __construct(
        string $marca,
        int $id=null,
        string $publicId=null,
        bool $activo=true,
        $created_at=null,
        $updated_at=null,
        $fecha_eliminado=null
    ) {
        $this->marca=$marca;
        $this->id=$id;
        $this->publicId=$publicId;
        $this->activo=$activo;
        $this->created_at=$this->setDateTime($created_at);
        $this->updated_at=$this->setDateTime($updated_at);
        $this->fecha_eliminado=$this->setDateTime($fecha_eliminado);
    }

    private function setDateTime($dateItem){
        if($dateItem==null) return null;
        if(is_string($dateItem)) return new DateTime($dateItem);
        if($dateItem instanceof DateTime) return $dateItem;
        return null;
    }
}
