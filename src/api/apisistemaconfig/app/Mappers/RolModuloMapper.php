<?php

namespace App\Mappers;

use App\Contractors\IMapper;
use App\Contractors\Models\RolModulo;
use App\DTOs\RolModuloDTO;
use App\Helpers\DateTimeSetter;
use stdClass;

class RolModuloMapper implements IMapper
{
    /**
     * @param RolModuloDTO|stdClass $DTO
     * @return RolModulo|null
     */
    public function map($DTO)
    {
        if(!isset($DTO->rolPid) || !isset($DTO->moduloPid)) return null;
        $model=new RolModulo();
        if(isset($DTO->id)) $model->id=$DTO->id;
        if(isset($DTO->publicId)) $model->publicId=$DTO->publicId;
        if(isset($DTO->moduloId)) $model->moduloId=$DTO->moduloId;
        $model->rolPid=$DTO->rolPid;
        $model->moduloPid=$DTO->moduloPid;
        if(isset($DTO->created_at)) $model->created_at=DateTimeSetter::setDateTime($DTO->created_at);
        if(isset($DTO->updated_at)) $model->updated_at=DateTimeSetter::setDateTime($DTO->updated_at);
        if(isset($DTO->fecha_eliminado)) $model->fecha_eliminado=DateTimeSetter::setDateTime($DTO->fecha_eliminado);
        
        return $model;
    }


    /**
     * @param RolModulo|stdClass $model
     * @return RolModuloDTO|null
     */
    public function reverse($model)
    {
        
        if(!isset($model->rolPid) || !isset($model->moduloPid)) return null;
        $dto= new RolModuloDTO();
        $dto->rolPid=$model->rolPid;
        $dto->moduloPid=$model->moduloPid;
        if(isset($model->publicId)) $dto->publicId=$model->publicId;

        return $dto;
    }
    
}
