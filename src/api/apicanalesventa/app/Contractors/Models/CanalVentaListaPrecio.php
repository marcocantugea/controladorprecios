<?php

namespace App\Contractors\Models;

use DateTime;

final class CanalVentaListaPrecio
{
    public int $id;
    public string $publicId;
    public string $listaPid;
    public string $canalventaPid;
    public int $canalventaId;
    public DateTime $created_at;
    public DateTime $updated_at;
    public DateTime $fecha_eliminado;
}
