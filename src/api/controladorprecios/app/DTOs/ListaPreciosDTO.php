<?php

namespace App\DTOs;

use DateTime;
use JsonSerializable;

final class ListaPreciosDTO implements JsonSerializable
{
    public ?string $publicId;
    public string $descripcion;
    public string $codigo;
    public bool $activo;
    public DateTime $date_created;
    public DateTime $updated_at;
    public DateTime $fecha_eliminado;
    public DateTime $fecha_expira;
    public DateTime $fecha_inicia;

    public function jsonSerialize() : mixed
    {
        return array_filter((array) $this, function ($var) {
            return !is_null($var);
        });
    }
}
