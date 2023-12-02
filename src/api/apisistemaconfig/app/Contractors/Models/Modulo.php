<?php

namespace App\Contractors\Models;

use DateTime;

class Modulo{

    public int $id;
    public string $publicId;
    public string $nombre;
    public string $display;
    public bool $activo;
    public DateTime $created_at;
    public DateTime $updated_at;
    public DateTime $fecha_eliminado;

}