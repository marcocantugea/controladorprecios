<?php

namespace App\Contractors\Models;

use DateTime;

class Accion{
    
    public int $id;
    public string $publicId;
    public string $accion;
    public bool $activo;
    public DateTime $created_at;
    public DateTime $updated_at;
    public DateTime $fecha_eliminado;
}