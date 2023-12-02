<?php 

namespace App\Contractors\Models;

use DateTime;

class RolModulo{

    public int $id;
    public string $publicId;
    public string $rolPid;
    public string $moduloPid;
    public int $moduloId;
    public DateTime $created_at;
    public DateTime $updated_at;
    public DateTime $fecha_eliminado;

}