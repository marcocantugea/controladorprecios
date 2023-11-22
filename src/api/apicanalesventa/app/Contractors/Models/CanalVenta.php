<?php

namespace App\Contractors\Models;

use DateTime;

class CanalVenta {

    public int $id;
    public string $publicId;
    public string $nombre;
    public string $codigo;
    public bool $activo;
    public DateTime $created_at;
    public DateTime $updated_at;
    public Datetime $fecha_eliminado;

}