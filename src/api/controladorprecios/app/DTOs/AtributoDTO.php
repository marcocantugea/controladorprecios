<?php

namespace App\DTOs;

use JsonSerializable;

class AtributoDTO implements JsonSerializable
{
    public ?string $publicId;
    public string $atributo;
    public bool $activo;
    public $created_at;
    public $updated_at;
    public $fecha_eliminado;
    public bool $esSubatributo=false;

    public function __construct(
        string $atributo,
        string $publicId=null,
        bool $activo=true,
        $created_at=null,
        $updated_at=null,
        $fecha_eliminado=null,
        bool $esSubatributo=false
    ) {
        $this->atributo = $atributo;
        if (!empty($publicId))$this->publicId=$publicId;
        $this->activo=$activo;
        if(!empty($created_at)) $this->created_at=$created_at;
        if(!empty($updated_at)) $this->updated_at=$updated_at;
        if(!empty($fecha_eliminado)) $this->fecha_eliminado=$fecha_eliminado;
        $this->esSubatributo=$esSubatributo;
    }

    public function jsonSerialize(): mixed
    {
        return array_filter((array) $this,function($val){
            return !is_null($val);
        });
    }
    
}
