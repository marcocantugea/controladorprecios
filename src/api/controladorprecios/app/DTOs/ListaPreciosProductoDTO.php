<?php

namespace App\DTOs;

use DateTime;
use JsonSerializable;

final class ListaPreciosProductoDTO implements JsonSerializable
{
    public ?string $publicId;
    public string $productoPId;
    public string $listaPid;
    public ?DateTime $created_at;
    public ?DateTime $updated_at;
    public ?DateTime $fecha_eliminado;
    public float $precio;
    public bool $activo;

    public function __construct(string $productoPId, float $precio,string $listaPId,bool $activo=true) {
        $this->productoPId=$productoPId;
        $this->precio=$precio;
        $this->activo=$activo;
        $this->listaPid=$listaPId;
    }

    public function jsonSerialize() : mixed
    {
        return array_filter((array) $this, function ($var) {
            return !is_null($var);
        });
    }
}
