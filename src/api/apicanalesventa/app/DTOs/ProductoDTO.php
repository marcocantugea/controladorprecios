<?php

namespace App\DTOs;

use JsonSerializable;

class ProductoDTO implements JsonSerializable
{
    public string $publicId;
    public string $nombre;
    public string $descripcion;
    public string $codigo;
    public string $sku;
    public string $upc;
    public string $ean;

    public function jsonSerialize() :mixed
    {
        return array_filter((array) $this, function ($var) {
            return !is_null($var);
        });
    }

}
