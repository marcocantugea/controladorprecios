<?php

namespace App\Models;

use DateTime;

final class Organizacion
{
    public ?int $id;
    public ?string $publicId;
    public string $nombre;
    public string $descripcion;
    public string $codigo;
    public ?DateTime $created_at;
    public ?DateTime $updated_at;
    public ?DateTime $fecha_eliminado;
}
