<?php

namespace App\DTOs;

use JsonSerializable;
use stdClass;

class ListaPreciosDetalleDTO implements JsonSerializable
{
    public string $publicId;
    public string $productoId;
    public float $precio;
    public bool $activo;
    public stdClass $producto;

    public function jsonSerialize() :mixed
    {
        return array_filter((array) $this, function ($var) {
            return !is_null($var);
        });
    }
}
