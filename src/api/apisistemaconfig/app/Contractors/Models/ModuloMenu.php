<?php

namespace App\Contractors;

use DateTime;

class ModuloMenu{

    public int $id;
    public string $publicId;
    public string $moduloPid;
    public string $menuPid;
    public int $moduloId;
    public int $menuId;
    public DateTime $created_at;
    public DateTime $updated_at;
    public DateTime $fecha_eliminado;

}