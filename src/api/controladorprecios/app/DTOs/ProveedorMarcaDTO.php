<?php

namespace App\DTOs;


class ProveedorMarcaDTO {

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
}