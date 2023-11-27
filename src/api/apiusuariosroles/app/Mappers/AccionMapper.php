<?php

namespace App\Mappers;

use App\Contractors\IMapper;
use App\Contractors\Models\Accion;
use App\DTOs\AccionDTO;
use App\Helpers\DateTimeSetter;
use stdClass;

final class AccionMapper implements IMapper
{
    /**
     * map dto to model
     * @param AccionDTO|stdClass $DTO
     * @return Accion|null
     */
    public function map($DTO)
    {
        if(!isset($DTO->accion)) return null;
        $model=new Accion();
        $model->accion=$DTO->accion;
        if(isset($DTO->id)) $model->id=$DTO->id;
        if(isset($DTO->publicId)) $model->publicId=$DTO->publicId;
        if(isset($DTO->activo)) $model->activo=$DTO->activo;
        if(isset($DTO->created_at)) $model->created_at=DateTimeSetter::setDateTime($DTO->created_at);
        if(isset($DTO->updated_at)) $model->updated_at=DateTimeSetter::setDateTime($DTO->updated_at);
        if(isset($DTO->fecha_eliminado)) $model->fecha_eliminado=DateTimeSetter::setDateTime($DTO->fecha_eliminado);

        return $model;
    }

    /**
     * map model to dto
     * @param Accion|stdClass $DTO
     * @return AccionDTO|null
     */
    public function reverse($model)
    {
        if(!isset($model->accion)) return null;
        $dto= new AccionDTO();
        $dto->accion=$model->accion;
        $dto->publicId=$model->publicId;
        $dto->activo=$model->activo;

        return $dto;
    }
}
