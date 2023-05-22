<?php

namespace App\Contractors\Models;

use DateTime;

class Atributo
{
    public $id;
    public ?string $publicId;
    public string $atributo;
    public bool $activo=true;
    public ?\DateTime $created_at;
    public ?\DateTime $updated_at;
    public ?\DateTime $fecha_eliminado;
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

        if(!empty($created_at) && $created_at instanceof DateTime) {
            $this->created_at=$created_at;
        }else{
            $this->created_at=new DateTime($created_at);
        };

        if(!empty($updated_at) && $updated_at instanceof DateTime) {
            $this->updated_at=$updated_at;
        }else{
            $this->updated_at=new DateTime($updated_at);
        }

        if(!empty($fecha_eliminado) && $fecha_eliminado instanceof DateTime) {
            $this->fecha_eliminado=$fecha_eliminado;
        } else{
            $this->fecha_eliminado=new DateTime($fecha_eliminado);
        }
        $this->esSubatributo=$esSubatributo;
    }
}
