<?php

namespace App\Contractors\Models;

use App\Helpers\DateTimeSetter;
use DateTime;
use stdClass;

class UnidadMedida 
{
    public ?int $id;
    public ?string $publicId;
    public string $codigo;
    public string $unidadDeMedida;
    public bool $activo=true;
    public ?DateTime $created_at;
    public ?DateTime $updated_at;
    public ?DateTime $fecha_eliminado;

    public function __construct(string $codigo, 
                                string $unidadDeMedida, 
                                int $id=null, 
                                string $publicId=null, 
                                bool $activo=true, 
                                $created_at=null,
                                $updated_at=null,
                                $fecha_eliminado=null
                                ) {
        $this->id=$id;
        $this->publicId=$publicId;
        $this->codigo=$codigo;
        $this->unidadDeMedida=$unidadDeMedida;
        $this->activo=$activo;
        $this->created_at=DateTimeSetter::setDateTime($created_at);
        $this->updated_at=DateTimeSetter::setDateTime($updated_at);
        $this->fecha_eliminado=DateTimeSetter::setDateTime($fecha_eliminado);
    }
}
