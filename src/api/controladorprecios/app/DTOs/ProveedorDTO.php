<?php

namespace App\DTOs;

use App\Contractors\Models\ProveedorInfoBasic;
use DateTime;

class ProveedorDTO{

    public ?string $publicId;
    public string $codigo;
    public  string $nombreCorto;
    public bool $activo;
    public ?DateTime $created_at;
    public ?Datetime $updated_at;
    public ?DateTime $fecha_eliminado;

    public ?ProveedorInfoBasicDTO $infoBasic;

    public function __construct(string $codigo, 
                                    string $nombreCorto,
                                    string $publicId=null,
                                    bool $activo=false,
                                    $created_at=null,
                                    $updated_at=null,
                                    $fecha_eliminado=null
    ) 
    {
        $this->codigo=$codigo;
        $this->publicId=$publicId;
        $this->nombreCorto=$nombreCorto;
        $this->activo=$activo;
        $this->created_at=$created_at;
        $this->updated_at = $updated_at;
        $this->fecha_eliminado= $fecha_eliminado;
    }

}