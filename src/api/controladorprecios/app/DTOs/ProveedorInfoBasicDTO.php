<?php
namespace App\DTOs;

use App\DTOs\ProveedorDTO;
use DateTime;
use JsonSerializable;

class ProveedorInfoBasicDTO implements JsonSerializable
{

    public ?string $publicId;
    public string $nombre;
    public string $rasonSocial;
    public string $RFC;
    public bool $activo;
    public ?Datetime $created_at;
    public ?DateTime $updated_at;
    public ?DateTime $fecha_eliminado;
    public ?ProveedorDTO $proveedor;

    public function __construct(
        string $nombre,
        string $rasonSocial,
        string $RFC,
        string $publicId=null,
        bool $activo=false,
        $created_at=null,
        $updated_at=null,
        $fecha_eliminado=null
    ) {
        $this->nombre=$nombre;
        $this->rasonSocial=$rasonSocial;
        $this->RFC=$RFC;
        $this->publicId=$publicId;
        $this->activo=$activo;
        $this->created_at=$created_at;
        $this->updated_at=$updated_at;
        $this->fecha_eliminado=$fecha_eliminado;
    }

    public function jsonSerialize(): mixed
    {
        return array_filter((array) $this,function($val){
            return !is_null($val);
        });
    }

}