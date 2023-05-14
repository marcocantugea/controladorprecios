<?php

namespace App\Contractors\Models;

use DateTime;

class Categoria 
{
    public ?int $id;
    public ?string $publicId;
    public string $nombre;
    public bool $activo;
    public ?DateTime $created_at;
    public ?DateTime $updated_at;
    public ?DateTime $fecha_eliminado;
    public bool $esSubCategoria=false;
    public ?array $subCategoria;
}
