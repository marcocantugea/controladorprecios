<?php

namespace App\Contractors\Models;

use DateTime;

class Costo
{
    public ?int $id;
    public ?string $publicId;
    public int $proveedorId;
    public int $productoId;
    public float $costo;
    public bool $activo;
    public ?DateTime $created_at;
    public ?DateTime $updated_at;
    public ?DateTime $fecha_eliminado;
    public ?DateTime $expira_en;
    
    public ?string $proveedorPublicId;
    public ?string $productoPublicId;

    public ?Proveedor $proveedor;
    public ?Producto $producto;

    public function __construct(
        int $proveedorId,
        int $productoId,
        float $costo,
        int $id=null,
        string $publicId=null,
        bool $activo=false,
        $create_at=null,
        $updated_at=null,
        $fecha_eliminado=null,
        $expira_en = null,
        Proveedor $proveedor=null,
        Producto $producto=null
    ) {
        $this->proveedorId=$proveedorId;
        $this->productoId=$productoId;
        $this->costo=$costo;
        $this->id=$id;
        $this->publicId=$publicId;
        $this->activo=$activo;
        $this->created_at=$this->setDateTime($create_at);
        $this->updated_at=$this->setDateTime($updated_at);
        $this->fecha_eliminado=$this->setDateTime($fecha_eliminado);
        $this->expira_en=$this->setDateTime($expira_en);
        $this->proveedor=$proveedor;
        $this->producto=$producto;

    }


    private function setDateTime($dateItem){
        if($dateItem==null) return null;
        if(is_string($dateItem)) return new DateTime($dateItem);
        if($dateItem instanceof DateTime) return $dateItem;
        return null;
    }
}
