<?php

namespace App\DTOs;

use DateTime;
use JsonSerializable;

class CanalVentaListaPrecioDTO implements JsonSerializable
{
    public string $publicId;
    public string $listaPid;
    public string $canalventaPid;
    public DateTime $created_at;

    public function jsonSerialize() :mixed
    {
        return array_filter((array) $this, function ($var) {
            return !is_null($var);
        });
    }
}
