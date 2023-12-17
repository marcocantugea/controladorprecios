<?php

namespace App\DTOs;

use JsonSerializable;

class UnidadMedidaDTO implements JsonSerializable
{
    public ?string $publicId;
    public string $codigo;
    public string $unidadDeMedida;
    public bool $activo=true;

    public function __construct(string $codigo, string $unidadDeMedidad, string $publicId=null, bool $activo=true) {
        $this->codigo=$codigo;
        $this->unidadDeMedida=$unidadDeMedidad;
        $this->publicId=$publicId;
        $this->activo=$activo;
    }

    public function jsonSerialize(): mixed
    {
        return array_filter((array) $this,function($val){
            return !is_null($val);
        });
    }
}
