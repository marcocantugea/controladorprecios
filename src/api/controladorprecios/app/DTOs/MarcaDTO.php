<?php

namespace App\DTOs;

use App\Contractors\IMapper;

class MarcaDTO 
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
}
