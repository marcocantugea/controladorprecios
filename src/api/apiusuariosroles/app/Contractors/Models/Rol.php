<?php

namespace App\Contractors\Models;

use DateTime;

class Rol 
{
    public int $id;
    public string $publicId;
    public string $rol;
    public bool $activo;
    public DateTime $created_at;
    public Datetime $updated_at;
    public DateTime $fecha_eliminado;
}
