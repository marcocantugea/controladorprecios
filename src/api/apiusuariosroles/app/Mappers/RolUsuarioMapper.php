<?php

namespace   App\Mappers;

use App\Contractors\IMapper;
use App\Contractors\Models\RolUsuario;
use App\DTOs\RolUsuarioDTO;
use App\Helpers\DateTimeSetter;
use stdClass;

class RolUsuarioMapper implements IMapper
{
    /**
     * map dto to model
     * @param RolUsuarioDTO|stdClass $DTO
     * @return RolUsuario|null
     */
    public function map($DTO)
    {
        if(!isset($DTO->usuarioPid) && !isset($DTO->rolPid)) return null;
        $model=new RolUsuario();
        $model->usuarioPid=$DTO->usuarioPid;
        $model->rolPid=$DTO->rolPid;
        if(isset($DTO->publicId)) $model->publicId=$DTO->publicId;
        if(isset($DTO->id)) $model->id=$DTO->id;
        if(isset($DTO->usuarioId)) $model->usuarioId=$DTO->usuarioId;
        if(isset($DTO->rolId)) $model->rolId=$DTO->rolId;
        if(isset($DTO->created_at)) $model->created_at=DateTimeSetter::setDateTime($DTO->created_at);
        if(isset($DTO->updated_at)) $model->updated_at=DateTimeSetter::setDateTime($DTO->updated_at);
        if(isset($DTO->fecha_eliminado)) $model->fecha_eliminado=DateTimeSetter::setDateTime($DTO->fecha_eliminado);

        return $model;
    }

    /**
     * map model to dto
     * @param RolUsuario|stdClass $model
     * @return RolUsuarioDTO|null 
     */
    public function reverse($model)
    {
        if(!isset($model->usuarioPid) && !isset($model->rolPid)) return null;

        $dto=new RolUsuarioDTO();
        if(isset($model->publicId)) $dto->publicId=$model->publicId;
        $dto->usuarioPid=$model->usuarioPid;
        $dto->rolPid=$model->rolPid;


        return $dto;
        
    }
}
