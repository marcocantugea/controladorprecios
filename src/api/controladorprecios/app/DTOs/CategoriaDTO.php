<?php

namespace App\DTOs;

use DateTime;

class CategoriaDTO
{
    public ?int $id;
    public ?string $publicId;
    public string $nombre;
    public bool $activo;
    public ?DateTime $created_at;
    public ?DateTime $updated_at;
    public ?DateTime $fecha_eliminado;
    public bool $esSubcategoria=false;
    public ?array $subcategoria=[];

    public function __construct(
        string $nombre,
        bool $activo=true,
        DateTime $created_at=null,
        Datetime $updated_at=null,
        DateTime $fecha_eliminado=null,
        string $publicId=null,
        bool $esSubCategoria=false
    ) {
        $this->nombre=$nombre;
        $this->activo=$activo;
        $this->created_at=(empty($created_at)) ? null : $created_at;
        $this->updated_at=(empty($updated_at)) ? null : $updated_at;
        $this->fecha_eliminado=(empty($fecha_eliminado)) ? null : $fecha_eliminado;
        $this->publicId=$publicId;
        $this->esSubcategoria=$esSubCategoria;
    }
}
