<?php

namespace App\DTOs;

use App\Contractors\IMapper;
use JsonSerializable;

class MarcaDTO implements JsonSerializable
{
    public ?string $publicId;
    public string $marca;
    public bool $activo;

    public function __construct(
        string $marca,
        string $publicId=null,
        bool $activo=true
    ) {
        $this->marca=$marca;
        $this->publicId=$publicId;
        $this->activo=$activo;
    }

    public function jsonSerialize(): mixed
    {
        return array_filter((array) $this,function($val){
            return !is_null($val);
        });
    }
}
