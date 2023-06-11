<?php

namespace   App\Contractors\Models;

use App\Helpers\DateTimeSetter;
use DateTime;

class ProveedorMarca
{
    public ?int $id;
    public int $proveedorId;
    public int $marcaId;
    public bool $activo;
    public ?DateTime $created_at;
    public ?DateTime $updated_at;
    public ?Datetime $fecha_eliminado;
    public ?string $marcaPublicId;
    public ?string $proveedorPublicId;

    public ?Proveedor $proveedor;
    public ?Marca $marca;

    public function __construct(
        int $marcaId,
        int $proveedorId,
        int $id=null,
        bool $activo=false,
        $created_at=null,
        $updated_at=null,
        $fecha_eliminado=null
    ) {
        $this->proveedorId=$proveedorId;
        $this->marcaId=$marcaId;
        $this->id=$id;
        $this->activo=$activo;
        $this->created_at=DateTimeSetter::setDateTime($created_at);
        $this->updated_at=DateTimeSetter::setDateTime($updated_at);
        $this->fecha_eliminado=DateTimeSetter::setDateTime($fecha_eliminado);
    }
}
