<?php

namespace App\Mappers;

use App\Contractors\IMapper;
use App\Contractors\Models\CanalVenta;
use App\DTOs\CanalVentaDTO;
use App\Helpers\DateTimeSetter;
use stdClass;

class CanalesVentaMapper implements IMapper
{
    /**
     * Map dto to model
     * @param CanalVentaDTO|stdClass @dto
     * @return CanalVenta|null
     */
    public function map($dto){
        if(!isset($dto->nombre)) return null;
        $model= new CanalVenta();
        if(isset($dto->publicId))$model->publicId=$dto->publicId;
        $model->nombre=$dto->nombre;
        $model->codigo= (isset($dto->codigo)) ? $dto->codigo : null;
        $model->activo= (isset($dto->activo)) ? $dto->activo: false;
        if (isset($dto->created_at)) $model->created_at=DateTimeSetter::setDateTime($dto->created_at);
        if (isset($dto->updated_at)) $model->updated_at=DateTimeSetter::setDateTime($dto->updated_at);
        if (isset($dto->fecha_eliminado)) $model->fecha_eliminado=DateTimeSetter::setDateTime($dto->fecha_eliminado);

        return $model;
    }

    /**
     * Map Model to Dto
     * @param CanalVenta|stdClass $model
     * @return CanalVentaDTO|null
     */
    public function reverse($model)
    {
        $dto= new CanalVentaDTO();
        if(isset($model->publicId)) $dto->publicId=$model->publicId;
        $dto->nombre=$model->nombre;
        $dto->codigo=$model->codigo;
        $dto->activo=boolval($model->activo);

        return $dto;
    }
}
