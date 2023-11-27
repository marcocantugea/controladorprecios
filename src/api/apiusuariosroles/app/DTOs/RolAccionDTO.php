<?php

namespace App\DTOs;

use JsonSerializable;

class RolAccionDTO implements JsonSerializable
{
    public string $publicId;
    public string $rolPid;
    public string $accionPid;
    public AccionDTO $accion;
    
    public function jsonSerialize(): mixed
    {
        return array_filter((array) $this,function($var){
            return !is_null($var);
        });
    }

}
