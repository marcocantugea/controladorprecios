<?php

namespace App\DTOs;

use JsonSerializable;

class OrganizacionDTO implements JsonSerializable
{
    public ?string $publicId;
    public string $nombre;
    public string $descripcion;
    public string $codigo;

    public function jsonSerialize(): mixed
    {
        return array_filter((array) $this,function($val){
            return !is_null($val);
        });
    }
}
