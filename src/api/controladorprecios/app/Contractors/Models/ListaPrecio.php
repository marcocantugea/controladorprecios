<?php

namespace App\Contractors\Models;

use DateTime;

class ListaPrecio 
{
    public int $id;
    public string $publicid;
    public string $descripcion;
    public string $codigo;
    public bool $activo;
    public DateTime $date_created;
    public DateTime $updated_at;
    public DateTime $fecha_eliminado;
    public DateTime $fecha_expira;
    public DateTime $fecha_inicia;
    
}
