<?php

namespace App\Contractors\Models;

use DateTime;

class ProductoOrganizacion 
{
    public string $publicId;
    public string $productoId;
    public Producto $producto;
    public string $organizacionId;
    public DateTime $created_at;
    public DateTime $updated_at;
    public DateTime $fecha_eliminado;
}
