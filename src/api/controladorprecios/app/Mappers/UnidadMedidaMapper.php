<?php

namespace App\Mappers;

use App\Contractors\IMapper;
use App\Contractors\Models\UnidadMedida;
use App\DTOs\UnidadMedidaDTO;
use \DateTime;
use stdClass;

class UnidadMedidaMapper  implements IMapper
{
    public function map($DTO)
    {
        if(!isset($DTO->codigo) || !isset($DTO->unidadDeMedida)) return null;
        $model= new UnidadMedida($DTO->codigo,$DTO->unidadDeMedida);
        if(isset($DTO->publicId)) $model->publicId=$DTO->publicId;
        if(isset($DTO->activo)) $model->activo=boolval($DTO->activo);
        if(isset($DTO->created_at)) $model->created_at=$this->setDateTime($DTO->created_at);
        if(isset($DTO->updated_at)) $model->updated_at=$this->setDateTime($DTO->updated_at);
        if(isset($DTO->fecha_eliminado)) $model->fecha_eliminado=$this->setDateTime($DTO->fecha_eliminado);

        return $model;
    }

    public function reverse($model)
    {
        if(!isset($model->codigo) || !isset($model->unidadDeMedida)) return null;
        $dto= new UnidadMedidaDTO($model->codigo,$model->unidadDeMedida);
        if(isset($model->publicId)) $dto->publicId=$model->publicId;
        if(isset($model->activo)) $dto->activo=boolval($model->activo);

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
