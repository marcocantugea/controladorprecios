<?php

namespace App\DTOs;

use JsonSerializable;

class EquivalenciaDTO implements JsonSerializable
{
    public ?string $publicId;
    public string $productoPublicIdEqu;
    public ?int $productoIdEqu;
    public ?int $productoId;
    public string $productoPublicId;

    public ?ProductoDTO $producto;

    public function __construct(
        string $productoPublicId,
        string $productoPublicIdEqu,
        string $publicId =null,
        ProductoDTO $producto=null
    ) {
        $this->productoPublicId=$productoPublicId;
        $this->productoPublicIdEqu=$productoPublicIdEqu;
        $this->publicId = $publicId;
        $this->producto = $producto;
    }

    public function jsonSerialize() :mixed
    {
        return array_filter((array) $this, function ($var) {
            return !is_null($var);
        });
    }
}
