<?php

namespace App\Mappers;

use App\Contractors\IMapper;
use App\Contractors\Models\Modulo;
use App\DTOs\ModuloDTO;
use App\Helpers\DateTimeSetter;
use stdClass;

final class ModuloMapper implements IMapper
{
    /**
     * map dto to model
     * @param ModuloDTO|stdClass $DTO
     * @return Modulo|null
     */
    public function map($DTO)
    {
        if(!isset($DTO->nombre) || !isset($DTO->display)) return null;

        $model= new Modulo();
        $model->nombre=$DTO->nombre;
        $model->display=$DTO->display;
        if(isset($DTO->publicId)) $model->publicId=$DTO->publicId;
        if(isseT($DTO->id)) $model->id=$DTO->id;
        if(isset($DTO->activo)) $model->activo=$DTO->activo;
        if(isset($DTO->created_at)) $model->created_at=DateTimeSetter::setDateTime($DTO->created_at);
        if(isset($DTO->updated_at)) $model->updated_at=DateTimeSetter::setDateTime($DTO->updated_at);
        if(isset($DTO->fecha_eliminado)) $model->fecha_eliminado=DateTimeSetter::setDateTime($DTO->fecha_eliminado);

        return $model;
    }

    /**
     * convert model to dto
     * @param Modulo|stdClass $model
     * @return ModuloDTO|null
     */
    public function reverse($model)
    {
        if(!isset($model->nombre) || !isset($model->display)) return null;
        $dto=new ModuloDTO();
        $dto->nombre=$model->nombre;
        $dto->display=$model->display;
        if(isset($model->publicId))$dto->publicId = $model->publicId;
        if(isset($model->activo)) $dto->activo=$model->activo;

        return $dto;
    }
}
