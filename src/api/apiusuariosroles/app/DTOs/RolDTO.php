<?php

namespace App\DTOs;

use JsonSerializable;

class RolDTO implements JsonSerializable
{
    public string $publicId;
    public string $rol;
    public bool $activo;
    
    public function jsonSerialize()
    {
        return array_filter((array) $this, function ($var) {
            return !is_null($var);
        });
    }
}
