<?php

namespace App\DTOs;

use App\Contractors\Models\Marca;
use App\Contractors\Models\UnidadMedida;

class ProductoAtributoDTO 
{
    public string $productoId;
    public string $atributoId;
    public ?string $atributo;
    public string $valor;
    public ?UnidadMedidaDTO $unidadMedida;
    public ?MarcaDTO $marca;

    public function __construct(string $productId,string $atributoId,string $valor,UnidadMedidaDTO $unidadMedida=null, MarcaDTO $marca=null,string $atributo=null){
        $this->productoId=$productId;
        $this->atributoId=$atributoId;
        $this->valor=$valor;
        $this->unidadMedida=$unidadMedida;
        $this->marca=$marca;
        $this->atributo=$atributo;
    }

}
