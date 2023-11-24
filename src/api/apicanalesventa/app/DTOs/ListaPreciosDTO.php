<?php

namespace App\DTOs;

use DateTime;
use JsonSerializable;

class ListaPreciosDTO implements JsonSerializable
{
    public string $publicId;
    public string $descripcion;
    public string $codigo;
    public bool $activo;
    public DateTime $fechaInicio;
    public DateTime $fechaExpira;
    public array $precios;

    public function jsonSerialize() :mixed
    {
        return array_filter((array) $this, function ($var) {
            return !is_null($var);
        });
    }

}
