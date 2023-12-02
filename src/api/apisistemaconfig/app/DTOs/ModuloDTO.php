<?php

namespace App\DTOs;

use JsonSerializable;

final class ModuloDTO implements JsonSerializable
{
    public string $publicId;
    public string $nombre;
    public string $display;
    public string $activo;
    public array $menus;
    
    public function jsonSerialize(): mixed
    {
        return array_filter((array) $this,function($val){
            return !is_null($val);
        });
    }
}
