<?php

namespace App\DTOs;

class ProveedorProductoDTO{

    public string $proveedorPublicId;
    public string $productoPublicId;
    public ?string $codigo;
    public ?int $proveedorId;
    public ?int $productoId;

    public function __construct(
        string $proveedorPublicId,
        string $productoPublicId,
        string $codigo=null
    ) {
        $this->proveedorPublicId=$proveedorPublicId;
        $this->productoPublicId=$productoPublicId;
        $this->codigo=$codigo;
    }

}