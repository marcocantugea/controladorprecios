<?php

namespace App\Contractors\Models;

use App\Helpers\DateTimeSetter;
use DateTime;
use Illuminate\Support\Collection;

class Proveedor
{
    public ?int $id;
    public ?string $publicId;
    public string $codigo;
    public string $nombreCorto;
    public bool $activo=false;
    public ?DateTime $created_at;
    public ?Datetime $updated_at;
    public ?DateTime $fecha_eliminado;

    public ?ProveedorInfoBasic $infoBasic;
    public ?Collection $productos;
    public ?Collection $marcas;
    public ?Collection $proveedorProductos;
    public ?Collection $proveedorMarcas;

    public function __construct(string $codigo, 
                                    string $nombreCorto,
                                    int $id=null, 
                                    string $publicId=null,
                                    bool $activo=false,
                                    $created_at=null,
                                    $updated_at=null,
                                    $fecha_eliminado=null
    ) 
    {
        $this->codigo=$codigo;
        $this->id=$id;
        $this->publicId=$publicId;
        $this->nombreCorto=$nombreCorto;
        $this->activo=$activo;
        $this->created_at=DateTimeSetter::setDateTime($created_at);
        $this->updated_at = DateTimeSetter::setDateTime($updated_at);
        $this->fecha_eliminado= DateTimeSetter::setDateTime($fecha_eliminado);
    }

    public function addProducto(Producto $producto):Proveedor{
        $this->productos->add($producto);
        return $this;
    }

    public function addMarca(Marca $marca):Proveedor{
        $this->marcas->add($marca);
        return $this;
    }

    public function addProveedorProducto(ProveedorProducto $rel):Proveedor{
        $this->proveedorProductos->add($rel);
        return $this;
    }

    public function addProveedorMarcas(ProveedorMarca $rel):Proveedor{
        $this->proveedorMarcas->add($rel);
        return $this;
    }
}
