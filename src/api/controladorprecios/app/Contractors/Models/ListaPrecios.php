<?php

namespace App\Contractors\Models;

use App\Helpers\DateTimeSetter;
use DateTime;

class ListaPrecios 
{
 
    public ?int $id;
    public ?string $publicId;
    public string $nombre;
    public string $descripcion;
    public DateTime $fecha_inicio;
    public DateTime $fecha_expira;
    public ?DateTime $created_at;
    public ?DateTime $updated_at;
    public ?DateTime $fecha_eliminado;
    public bool $activo=false;
    public float $margenUtilidad=0;
    
    public function __construct(
        string $nombre,
        string $descripcion,
        $fecha_inicio,
        $fecha_expira,
        int $id=null,
        string $publicId=null,
        $created_at=null,
        $updated_at=null,
        $fecha_eliminado=null,
        bool $activo=false,
        float $margenUtilidad=0
    ) {
        $this->nombre=$nombre;
        $this->descripcion=$descripcion;
        $this->fecha_inicio=DateTimeSetter::setDateTime($fecha_inicio);
        $this->fecha_expira=DateTimeSetter::setDateTime($fecha_expira);
        $this->created_at= DateTimeSetter::setDateTime($created_at);
        $this->updated_at=DateTimeSetter::setDateTime($updated_at);
        $this->fecha_eliminado=DateTimeSetter::setDateTime($fecha_eliminado);
        $this->id=$id;
        $this->publicId=$publicId;
        $this->activo=$activo;
        $this->margenUtilidad=$margenUtilidad;
    }

}
