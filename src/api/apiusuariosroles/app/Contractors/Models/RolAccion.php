<?php

namespace App\Contractors\Models;

use DateTime;

class RolAccion
{
    public int $id;
    public string $publicId;
    public int $rolId;
    public int $accionId;
    public string $rolPid;
    public string $accionPid;
    public DateTime $created_at;
    public DateTime $updated_at;
    public DateTime $fecha_eliminado;
}
