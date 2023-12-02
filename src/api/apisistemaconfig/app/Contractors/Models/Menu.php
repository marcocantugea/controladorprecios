<?php

namespace App\Contractors\Models;

use DateTime;

class Menu {

    public int $id;
    public string $publicId;
    public string $nombre;
    public string $display;
    public bool $activo;
    public bool $essubmenu;
    public int $orden;
    public int $submenuId;
    public DateTime $created_at;
    public DateTime $updated_at;
    public DateTime $fecha_eliminado;
    public string $accion;

}