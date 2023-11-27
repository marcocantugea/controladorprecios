<?php

namespace App\Mappers;

use App\Contractors\IMapper;
use App\Contractors\Models\Rol;
use App\DTOs\RolDTO;
use App\Helpers\DateTimeSetter;
use stdClass;

final class RolMapper implements IMapper
{
    /**
     * map dto or std class to model
     * @param RolDTO|stdClass $DTO;
     * @return Rol|null
     */
    public function map($DTO)
    {
        if(!isset($DTO->rol)) return null;
        $model= new Rol();
        $model->rol=$DTO->rol;
        if(isset($DTO->id)) $model->id=$DTO->id;
        if(isset($DTO->publicId)) $model->publicId=$DTO->publicId;
        if(isset($DTO->activo)) $model->activo=boolval($DTO->activo);
        if(isset($DTO->created_at)) $model->created_at=DateTimeSetter::setDateTime($DTO->created_at);
        if(isset($DTO->update_at)) $model->updated_at=DateTimeSetter::setDateTime($DTO->update_at);
        if(isset($DTO->fecha_eliminado)) $model->fecha_eliminado=DateTimeSetter::setDateTime($DTO->fecha_eliminado);

        return $model;
    } 

    /**
     * map model to dto
     * @param Rol|stdClass $model
     * @return RolDT|null
     */
    public function reverse($model)
    {
        if(!isset($model->rol)) return null;
        $dto=new RolDTO();
        if(isset($model->publicId)) $dto->publicId=$model->publicId;
        $dto->rol=$model->rol;
        $dto->activo=$model->activo;

        return $dto;

    }
}
