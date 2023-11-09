<?php

namespace App\DTOs;

use stdClass;

class ProductoOrganizacionDTO
{
    public ?string $publicId;
    public ?ProductoDTO $producto;
    public string $organizacionId;
    public stdClass $organizacion;

    public function __construct(string $organizacionId,string $publicId=null,ProductoDTO $producto=null) {
        $this->organizacionId=$organizacionId;
        if(!empty($publicId)) $this->publicId=$publicId;
        if(!empty($producto)) $this->producto=$producto;
    }
}
