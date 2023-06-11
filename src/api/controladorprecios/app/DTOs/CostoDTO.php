<?php

namespace App\DTOs;

use DateTime;
use JsonSerializable;

class CostoDTO implements JsonSerializable
{

    public string $proveedorPublicId;
    public ?string $codigoProveedor;
    public ?string $nombreCorto;
    public string $productoPublicId;
    public ?string $nombreProducto;
    public float $costo;
    public ?DateTime $expiraEn;
    public ?DateTime $created_at;
    public ?DateTime $fecha_eliminado;
    public ?int $proveedorId;
    public ?int $productoId;
    public ?string $publicId;

    public function __construct(
        string $proveedorPublicId,
        string $productoPublicId,
        float $costo,
        string $codigoProveedor=null,
        string $nombreCorto=null,
        string $nombreProducto=null,
        $expiraEn=null,
        $created_at=null,
        $fecha_eliminado=null
    ) {
        $this->proveedorPublicId=$proveedorPublicId;
        $this->productoPublicId=$productoPublicId;
        $this->costo=$costo;
        $this->codigoProveedor=$codigoProveedor;
        $this->nombreCorto=$nombreCorto;
        $this->nombreProducto=$nombreProducto;
        $this->expiraEn=$expiraEn;
        $this->created_at=$created_at;
        $this->fecha_eliminado=$fecha_eliminado;
    }

    public function jsonSerialize()
    {
        return array_filter((array) $this, function ($var) {
            return !is_null($var);
        });
    }

}