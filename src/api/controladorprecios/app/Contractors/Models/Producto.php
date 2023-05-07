<?php

namespace App\Contractors\Models;

use DateTime;

class Producto 
{
    public ?int $id;
    public ?string $publicId;
    public string $nombre;
    public string $descripcion;
    public string $codigo;
    public string $sku;
    public string $upc;
    public string $ean;
    public bool $activo;
    public DateTime $created_at;
    public DateTime $updated_at;
    public DateTime $fecha_eliminado;
}
