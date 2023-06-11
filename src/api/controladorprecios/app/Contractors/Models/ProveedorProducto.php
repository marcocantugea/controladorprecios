<?php

namespace App\Contractors\Models;

use App\Helpers\DateTimeSetter;
use DateTime;

class ProveedorProducto 
{
    public ?int $id;
    public int $proveedorId;
    public int $productoId;
    public bool $activo;
    public ?DateTime $created_at;
    public ?DateTime $updated_at;
    public ?Datetime $fecha_eliminado;
    public ?string $proveedorPublicId;
    public ?string $productoPublicId;

    public ?Proveedor $proveedor;
    public ?Producto $producto;

    public function __construct(
        int $productoId,
        int $proveedorId,
        int $id=null,
        bool $activo=false,
        $created_at=null,
        $updated_at=null,
        $fecha_eliminado=null
    ) {
        $this->proveedorId=$proveedorId;
        $this->productoId=$productoId;
        $this->id=$id;
        $this->activo=$activo;
        $this->created_at=DateTimeSetter::setDateTime($created_at);
        $this->updated_at=DateTimeSetter::setDateTime($updated_at);
        $this->fecha_eliminado=DateTimeSetter::setDateTime($fecha_eliminado);
    }

}
