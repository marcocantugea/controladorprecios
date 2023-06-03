<?php

namespace App\Contractors\Models;

use DateTime;

class ProveedorInfoBasic
{
    public ?int $id;
    public ?string $publicId;
    public ?int $proveedorId;
    public string $nombre;
    public string $rasonSocial;
    public string $RFC;
    public bool $activo;
    public ?Datetime $created_at;
    public ?DateTime $updated_at;
    public ?DateTime $fecha_eliminado;

    public ?Proveedor $proveedor;
    
    public function __construct(
        string $nombre,
        string $rasonSocial,
        string $RFC,
        int $id=null,
        string $publicId=null,
        bool $activo=false,
        $created_at=null,
        $updated_at=null,
        $fecha_eliminado=null
    ) {
        $this->proveedorId=$id;
        $this->nombre=$nombre;
        $this->rasonSocial=$rasonSocial;
        $this->RFC=$RFC;
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
