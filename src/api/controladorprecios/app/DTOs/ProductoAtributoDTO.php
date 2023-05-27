<?php

namespace App\DTOs;

use App\Contractors\Models\UnidadMedida;

class ProductoAtributoDTO 
{
    public string $productoId;
    public string $atributoId;
    public string $valor;
    public ?UnidadMedidaDTO $unidadMedida;

    public function __construct(string $productId,string $atributoId,string $valor,UnidadMedida $unidadMedida=null){
        $this->productoId=$productId;
        $this->atributoId=$atributoId;
        $this->valor=$valor;
        $this->unidadMedida=$unidadMedida;
    }

}
