<?php

namespace App\DTOs;

use App\Contractors\Models\Marca;
use App\Contractors\Models\UnidadMedida;
use JsonSerializable;

class ProductoAtributoDTO implements JsonSerializable
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

    public function jsonSerialize(): mixed
    {
        return array_filter((array) $this,function($val){
            return !is_null($val);
        });
    }

}
