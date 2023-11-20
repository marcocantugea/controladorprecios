<?php

namespace App\Contractors\Models;

use DateTime;

final class ListaPreciosProducto
{
    public int $id;
    public string $publicId;
    public string $productoPId;
    public int $productoId;
    public DateTime $created_at;
    public DateTime $updated_at;
    public DateTime $fecha_eliminado;
    public float $precio;
    public bool $activo; 
    public string $listaPid;
    public int $listapreciosId;

    public function __construct(string $productoPId, float $precio,string $listaPid,bool $activo=true) {

        $this->productoPId=$productoPId;
        $this->precio=$precio;
        $this->activo=$activo;
        $this->listaPid=$listaPid;
    }

}
