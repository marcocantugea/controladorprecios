<?php

namespace App\DTOs;

use JsonSerializable;

class ProveedorProductoDTO implements JsonSerializable
{

    public string $proveedorPublicId;
    public string $productoPublicId;
    public ?string $codigo;
    public ?int $proveedorId;
    public ?int $productoId;

    public function __construct(
        string $proveedorPublicId,
        string $productoPublicId,
        string $codigo=null
    ) {
        $this->proveedorPublicId=$proveedorPublicId;
        $this->productoPublicId=$productoPublicId;
        $this->codigo=$codigo;
    }


    public function jsonSerialize(): mixed
    {
        return array_filter((array) $this,function($val){
            return !is_null($val);
        });
    }
}