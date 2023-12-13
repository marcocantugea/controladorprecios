<?php

namespace App\Contractors\Models;

use DateTime;

class RolUsuario
{
    public int $id;
    public string $publicId;
    public string $usuarioPid;
    public string $rolPid;
    public int $usuarioId;
    public int $rolId;
    public DateTime $created_at;
    public DateTime $updated_at;
    public DateTime $fecha_eliminado;
}
