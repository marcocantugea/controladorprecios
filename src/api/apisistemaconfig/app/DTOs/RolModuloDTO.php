<?php

namespace App\DTOs;

use JsonSerializable;

class RolModuloDTO implements JsonSerializable
{
    
    public string $publicId;
    public string $rolPid;
    public string $moduloPid;

    public function jsonSerialize(): mixed
    {
        return array_filter((array) $this, function($val){
            return !is_null($val);
        });
    }
}
