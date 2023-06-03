<?php

namespace App\Mappers;

use App\Contractors\IMapper;
use App\Contractors\Models\ProveedorInfoBasic;
use App\DTOs\ProveedorInfoBasicDTO;
use stdClass;
use DateTime;

class ProveedorInfoBasicMapper implements IMapper{

    /**
     * Make a model
     * @param ProveedorInfoBasicDTO|stdClass $DTO
     * @return ProveedorInfoBasic|null 
     */
    public function map($DTO)
    {
        if(!isset($DTO->nombre) || !isset($DTO->rasonSocial) ) return null;
        $model= new ProveedorInfoBasic($DTO->nombre,$DTO->rasonSocial,$DTO->RFC);
        $model->id= $DTO->id ?? null;
        $model->publicId = $DTO->publicId ?? null;
        $model->activo= (isset($DTO->activo)) ? boolval($DTO->activo) : false;
        $model->created_at= (isset($DTO->created_at)) ? $this->setDateTime($DTO->created_at) : null;
        $model->updated_at= (isset($DTO->updated_at)) ? $this->setDateTime($DTO->updated_at) : null;
        $model->fecha_eliminado= (isset($DTO->fecha_eliminado)) ? $this->setDateTime($DTO->fecha_eliminado) : null;

        return $model;
    }

    /**
     * Make a DTO
     * @param ProveedorInfoBasic|stdClass $model
     * @return ProveedorInfoBasicDTO|null
     */
    public function reverse($model)
    {
        if(!isset($model->nombre) || !isset($model->rasonSocial) || !isset($model->RFC)) return null;
        $dto= new ProveedorInfoBasicDTO($model->nombre,$model->rasonSocial,$model->RFC);
        $dto->publicId=$model->publicId ?? null;
        $dto->activo = (isset($model->activo)) ? boolval($model->activo) : false;
        $dto->created_at= (isset($model->created_at)) ? $this->setDateTime($model->created_at) : null;
        $dto->updated_at= (isset($model->updated_at)) ? $this->setDateTime($model->updated_at) : null;
        $dto->fecha_eliminado= (isset($model->fecha_eliminado)) ? $this->setDateTime($model->fecha_eliminado) : null;

        return $dto;
    }

    private function setDateTime($dateItem){
        if($dateItem==null) return null;
        if(is_string($dateItem)) return new DateTime($dateItem);
        if($dateItem instanceof DateTime) return $dateItem;
        if($dateItem instanceof stdClass) return new DateTime($dateItem->date);
        return null;
    }

}