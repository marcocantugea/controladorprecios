<?php

namespace App\Mappers;

use App\Contractors\IMapper;
use App\Contractors\Models\ListaPrecio;
use App\DTOs\ListaPreciosDTO;
use App\Helpers\DateTimeSetter;
use stdClass;

class ListaPreciosMapper implements IMapper
{
    /**
     * Maps to ListaPrecio model
     * @param ListaPreciosDTO|stdClass $dto
     * @return ListaPrecio|null
     */
    public function map($dto){ 
        if(!isset($dto->descripcion) || !isset($dto->codigo)) return null;
        $model= new ListaPrecio();
        $model->descripcion= $dto->descripcion;
        $model->codigo= $dto->codigo;
        if(isset($dto->activo)) $model->activo=$dto->activo;
        if(isset($dto->date_create)) $model->date_created= DateTimeSetter::setDateTime($dto->date_create);
        if(isset($dto->updated_at)) $model->updated_at=DateTimeSetter::setDateTime($dto->updated_at);
        if(isset($dto->fecha_eliminado)) $model->fecha_eliminado=DateTimeSetter::setDateTime($dto->fecha_eliminado);
        if(isset($dto->fecha_expira)) $model->fecha_expira=DateTimeSetter::setDateTime($dto->fecha_expira);
        if(isset($dto->fecha_inicia)) $model->fecha_inicia=DateTimeSetter::setDateTime($dto->fecha_inicia);
        if(isset($dto->id)) $model->id= $dto->id;
        if(isset($dto->publicId)) $model->publicid=$dto->publicId;

        return $model;

    }

    /**
     * Maps to return a DTO
     * @param ListaPrecio|stdClass $model
     * @return ListaPreciosDTO|null
     */
    public function reverse($model){
        $dto = new ListaPreciosDTO();
        if(isset($model->publicid)) $dto->publicId= $model->publicid;
        $dto->descripcion= $model->descripcion;
        $dto->codigo= $model->codigo;
        $dto->activo= $model->activo;
        if(isset($model->date_created)) $dto->date_created=DateTimeSetter::setDateTime( $model->date_create);
        if(isset($model->updated_at)) $dto->updated_at= DateTimeSetter::setDateTime($model->updated_at);
        $dto->fecha_expira=DateTimeSetter::setDateTime( $model->fecha_expira);
        $dto->fecha_inicia=DateTimeSetter::setDateTime($model->fecha_inicia);

        return $dto;
    }
}
