<?php

namespace App\Mappers;

use App\Contractors\IMapper;
use App\Contractors\Models\RolAccion;
use App\DTOs\RolAccionDTO;
use App\Helpers\DateTimeSetter;
use stdClass;

final class RolAccionMapper implements IMapper
{
    /**
     * map dto to model
     * @param RolAccionDTO|stdClass $DTO
     * @return RolAccion|null
     */
    public function map($DTO)
    {
        if(!isset($DTO->rolPid) || !isset($DTO->accionPid)) return null;
        $model= new RolAccion();
        $model->rolPid=$DTO->rolPid;
        $model->accionPid=$DTO->accionPid;
        if(isset($DTO->id)) $model->id=$DTO->id;
        if(isset($DTO->publicId)) $model->publicId=$DTO->publicId;
        if(isset($DTO->rolId)) $model->rolId=$DTO->rolId;
        if(isset($DTO->accionId)) $model->accionId=$DTO->accionId;
        if(isset($DTO->created_at)) $model->created_at= DateTimeSetter::setDateTime($DTO->created_at);
        if(isset($DTO->updated_at)) $model->updated_at=DateTimeSetter::setDateTime($DTO->updated_at);
        if(isset($DTO->fecha_eliminado)) $model->fecha_eliminado=DateTimeSetter::setDateTime($DTO->fecha_eliminado);

        return $model;
    }

    /**
     * map model to dto
     * @param RolAccion $model
     * @return RolAccionDTO|null
     */
    public function reverse($model)
    {
        if(!isset($model->rolPid) || !isset($model->accionPid)) return null;
        $dto= new RolAccionDTO();
        $dto->rolPid=$model->rolPid;
        $dto->accionPid=$model->accionPid;
        if(isset($model->publicId))$dto->publicId= $model->publicId;

        return $dto;
    }
}
