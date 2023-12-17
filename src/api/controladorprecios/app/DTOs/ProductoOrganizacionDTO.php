<?php

namespace App\DTOs;

use JsonSerializable;
use stdClass;

class ProductoOrganizacionDTO implements JsonSerializable
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

    public function jsonSerialize(): mixed
    {
        return array_filter((array) $this,function($val){
            return !is_null($val);
        });
    }
}
