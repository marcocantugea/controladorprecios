<?php

namespace App\DTOs;

use JsonSerializable;

class ProveedorMarcaDTO implements JsonSerializable
 {

    public string $proveedorPublicId;
    public MarcaDTO $marca;
    public ?int $proveedorId;
    public ?int $marcaId;

    public function __construct(string $proveedorId,string $marcaId,string $marca="",MarcaDTO $marcaObj=null){
        $this->proveedorPublicId=$proveedorId;

        if(!empty($marcaObj)) {
            $this->marca=$marcaObj;
        }else{
            $this->marca=new MarcaDTO($marca,$marcaId);
        }
        
    }

    public function jsonSerialize(): mixed
    {
        return array_filter((array) $this,function($val){
            return !is_null($val);
        });
    }
}