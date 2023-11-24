<?php

namespace App\DTOs;

use DateTime;
use JsonSerializable;
use stdClass;

class ProductoDTO implements JsonSerializable
{
    public ?string $publicId;
    public string $nombre;
    public string $descripcion;
    public string $codigo;
    public ?string $sku;
    public ?string $upc;
    public ?string $ean;
    public bool $activo;
    public ?DateTime $created_at;
    public ?DateTime $updated_at;
    public ?DateTime $fecha_eliminado;
    public ?array $categorias;
    public ?array $atributos;
    public ?array $equivalencias; 
    public ?array $organizaciones;
    public ?array $listaPrecios;
 
    public function __construct(
        string $nombre, 
        string $descripcion,
        string $codigo,
        string $sku=null,
        string $upc=null,
        string $ean=null,
        bool $activo=true,
        DateTime $created_at=null,
        DateTime $updated_at=null,
        DateTime $fecha_eliminado=null,
        string $publicId=null
        ) {
        $this->nombre=$nombre;
        $this->descripcion=$descripcion;
        $this->codigo=$codigo;
        $this->sku=$sku;
        $this->upc=$upc;
        $this->ean=$ean;
        $this->activo=$activo;
        $this->created_at=$created_at;
        $this->updated_at=$updated_at;
        $this->fecha_eliminado=$fecha_eliminado;
        $this->publicId=$publicId;
    }

    public function jsonSerialize() : mixed
    {
        return array_filter((array) $this, function ($var) {
            return !is_null($var);
        });
    }
}
