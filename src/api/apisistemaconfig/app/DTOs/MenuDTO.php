<?php

namespace App\DTOs;

use JsonSerializable;

final class MenuDTO implements JsonSerializable
{
    public string $publicId;
    public string $nombre;
    public string $display;
    public bool $activo;
    public bool $essubmenu;
    public int $orden;
    public MenuDTO $submenu;
    public string $accion;

    public function jsonSerialize(): mixed
    {
        return array_filter((array) $this , function($val){
            return !is_null($val);
        });
    }
}
