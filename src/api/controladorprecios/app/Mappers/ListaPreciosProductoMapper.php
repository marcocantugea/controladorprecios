<?php

namespace App\Mappers;

use App\Contractors\IMapper;
use App\Contractors\Models\ListaPreciosProducto;
use App\DTOs\ListaPreciosProductoDTO;
use App\Helpers\DateTimeSetter;
use stdClass;

final class ListaPreciosProductoMapper implements IMapper
{
    /**
     * Map dto to model
     * @param ListaPreciosProductoDTO|stdClass $dto
     * @return ListaPreciosProducto|null
     */
    public function map($dto){
        if(!isset($dto->precio) || !isset($dto->productoPId) || !isset($dto->listaPid)) return null;
        $model= new ListaPreciosProducto($dto->productoPId,$dto->precio,$dto->listaPid);
        if(isset($dto->publicId)) $model->publicId= $dto->publicId;
        if(isset($dto->created_at)) $model->created_at = DateTimeSetter::setDateTime($dto->created_at);
        if(isset($dto->updated_at)) $model->updated_at = DateTimeSetter::setDateTime($dto->updated_at);
        if(isset($dto->fecha_eliminado)) $model->fecha_eliminado = DateTimeSetter::setDateTime($dto->fecha_eliminado);
        if(isset($dto->activo)) $model->activo = $dto->activo;
        if(isset($dto->id)) $model->id= $dto->id;
        if(isset($dto->productoId)) $model->productoId=$dto->productoId;
        if(isset($dto->listapreciosId)) $model->listapreciosId=$dto->listapreciosId;

        return $model;
    }

    /**
     * Map model to DTO
     * @param ListaPreciosProducto|stdClass $model
     * @return ListaPreciosProductoDTO|null
     */
    public function reverse($model){
        if(!isset($model->precio) || !isset($model->productoPId) || !isset($model->listaPid)) return null;
        $dto= new ListaPreciosProductoDTO($model->productoPId,$model->precio,$model->listaPid);
        if(isset($model->publicId)) $dto->publicId=$model->publicId;
        if(isset($model->created_at)) $dto->created_at = DateTimeSetter::setDateTime($model->created_at);
        if(isset($model->updated_at)) $dto->updated_at = DateTimeSetter::setDateTime($model->updated_at);
        if(isset($model->fecha_eliminado)) $dto->fecha_eliminado = DateTimeSetter::setDateTime($model->fecha_eliminado);
        if(isset($model->activo)) $dto->activo=$model->activo;

        return $dto;
    }
}
