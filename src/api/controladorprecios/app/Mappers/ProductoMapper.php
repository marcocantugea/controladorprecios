<?php

namespace App\Mappers;

use App\Contractors\IMapper;
use App\Contractors\Models\Producto;
use App\DTOs\ProductoDTO;
use App\Helpers\DateTimeSetter;
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
     * @param Producto|stdClass $product
     * @return ProductoDTO
     */
    public function reverse($product){
        
        $dto= new ProductoDTO($product->nombre,$product->descripcion,$product->codigo);
        $dto->sku= $product->sku ?? null;
        $dto->upc = $product->upc ?? null;
        $dto->ean = $product->ean ?? null;
        $dto->activo = isset($product->activo) ? boolval($product->activo) : false;
        if(isset($product->created_at)) $dto->created_at= DateTimeSetter::setDateTime($product->created_at);
        if(isset($product->updated_at)) $dto->updated_at= DateTimeSetter::setDateTime($product->updated_at);
        $dto->publicId = $dto->publicId ?? null;

        return $dto;
    }
}
