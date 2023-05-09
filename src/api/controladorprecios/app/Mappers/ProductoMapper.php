<?php

namespace App\Mappers;

use App\Contractors\IMapper;
use App\Contractors\Models\Producto;
use App\DTOs\ProductoDTO;
use stdClass;
use DateTime;

class ProductoMapper implements IMapper
{
    /**
     * Map data to producto model
     * @return Producto
     */
    public function map($productoDTO){
        $producto= new Producto();

        $producto->publicId=(empty($productoDTO->publicId))? null :$productoDTO->publicId;
        $producto->nombre=$productoDTO->nombre;
        $producto->descripcion=$productoDTO->descripcion;
        $producto->codigo=$productoDTO->codigo;
        $producto->sku=$productoDTO->sku;
        $producto->upc=$productoDTO->upc;
        $producto->ean=$productoDTO->ean;

        return $producto;
    }

    /**
     * Map data to producto dto model
     * @return ProductoDTO
     */
    public function reverse($product){
        $activo = empty($product->activo) ? true : boolval($product->activo);
        $created_at=(empty($product->created_at))?null: new DateTime($product->created_at);
        $updated_at=(empty($product->updated_at)) ? null :new DateTime($product->updated_at);
        $fecha_eliminado=(empty($product->fecha_eliminado)) ? null :new DateTime($product->fecha_eliminado);
        return new ProductoDTO(
            $product->nombre,
            $product->descripcion,
            $product->codigo,
            $product->sku,
            $product->upc,
            $product->ean,
            $activo,
            $created_at,
            $updated_at,
            $fecha_eliminado,
            $product->publicId
        );
    }
}
