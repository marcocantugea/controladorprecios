<?php

namespace App\Mappers;

use App\Contractors\IMapper;
use App\Contractors\Models\Proveedor;
use App\DTOs\ProveedorDTO;
use App\Helpers\DateTimeSetter;
use DateTime;
use stdClass;

class ProveedorMapper implements IMapper {

    /**
     * Make a Model
     * @param ProveedorDTO|stdClass $DTO
     * @return Proveedor|null
     */
    public function map($DTO){

        if(!isset($DTO->codigo) || !isset($DTO->nombreCorto) ) return null;
        $model= new Proveedor($DTO->codigo,$DTO->nombreCorto);
        $model->id=$DTO->id ?? null;
        $model->publicId=$DTO->publicId ?? null;
        $model->activo=(isset($DTO->activo)) ? boolval($DTO->activo) : false;
        $model->created_at= isset($DTO->created_at) ? DateTimeSetter::setDateTime($DTO->created_at) : null;
        $model->updated_at= isset($DTO->updated_at) ? DateTimeSetter::setDateTime($DTO->updated_at) : null;
        $model->fecha_eliminado= isset($DTO->fecha_eliminado) ? DateTimeSetter::setDateTime($DTO->fecha_eliminado) : null;

        return $model;
    }

    /**
     * Make a DTO
     * @param Proveedor|stdClass $model
     * @return ProveedorDTO|null
     */

    public function reverse($model)
    {
        if(!isset($model->codigo) || !isset($model->nombreCorto) ) return null;
        $dto=new ProveedorDTO($model->codigo,$model->nombreCorto);
        $dto->publicId=$model->publicId ?? null;
        $dto->activo= (isset($model->activo)) ? boolval($model->activo) : false;
        $dto->created_at = (isset($model->created_at)) ? DateTimeSetter::setDateTime($model->created_at) : null;
        $dto->updated_at= (isset($model->updated_at)) ? DateTimeSetter::setDateTime($model->updated_at) : null;
        $dto->fecha_eliminado = (isset($model->fecha_eliminado)) ? DateTimeSetter::setDateTime($model->fecha_eliminado) : null;
        
        return $dto;
    }
}