<?php

namespace App\DTOs;

use JsonSerializable;

class AccionDTO implements JsonSerializable
{
      
    public int $id;
    public string $publicId;
    public string $accion;
    public bool $activo;

    public function jsonSerialize(): mixed
    {
        return array_filter((array) $this, function ($var) {
            return !is_null($var);
        });
    }
}
