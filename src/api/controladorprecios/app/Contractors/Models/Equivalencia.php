<?php

namespace App\Contractors\Models;

use DateTime;

class Equivalencia {

    public ?int $id;
    public ?string $publicId;
    public int $productoId;
    public ?string $productoPublicId;
    public int $productoIdEqu;
    public ?string $productoPublicIdEqu;
    public ?DateTime $created_at;
    public ?DateTime $updated_at;
    public ?DateTime $fecha_elimiando;

    public function __construct(
        int $productoId,
        int $productoIdEqu,
        $id=null,
        string $publicId=null,
        string $productoPublicId=null,
        string $productoPublicIdEqu=null,
        $created_at=null,
        $updated_at=null,
        $fecha_elimiando=null
    ) {
          if(!empty($id)) $this->id=$id;
          $this->publicId=$publicId;
          $this->productoId=$productoId;
          $this->productoPublicId=$productoPublicId;
          $this->productoIdEqu=$productoIdEqu;
          $this->productoPublicIdEqu=$productoPublicIdEqu;
          $this->created_at = $this->setDateTime($created_at);
          $this->updated_at = $this->setDateTime($updated_at);
          $this->fecha_elimiando = $this->setDateTime($fecha_elimiando);
    }


    
    private function setDateTime($dateItem){
        if($dateItem==null) return null;
        if(is_string($dateItem)) return new DateTime($dateItem);
        if($dateItem instanceof DateTime) return $dateItem;
        return null;
    }
}