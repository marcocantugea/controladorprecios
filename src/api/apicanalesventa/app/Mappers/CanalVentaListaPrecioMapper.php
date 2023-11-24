<?php

namespace App\Mappers;

use App\Contractors\IMapper;
use App\DTOs\CanalVentaListaPrecioDTO;
use App\Helpers\DateTimeSetter;
use App\Contractors\Models\CanalVentaListaPrecio;
use Exception;
use stdClass;

class CanalVentaListaPrecioMapper implements IMapper
{
    /**
     * Map dto to model
     * @param CanalVentaListaPrecioDTO|stdClass $DTO
     * @return CanalVentaListaPrecio|null
     */
    public function map($DTO)
    {
        if(!isset($DTO->listaPid) || !isset($DTO->canalventaPid)) return null;
        $model= new CanalVentaListaPrecio();
        $model->listaPid=$DTO->listaPid;
        $model->canalventaPid=$DTO->canalventaPid;
        if(isset($DTO->canalventaId)) $model->canalventaId=$DTO->canalventaId;
        if(isset($DTO->id)) $model->id=$DTO->id;
        if(isset($DTO->publicId)) $model->publicId=$DTO->publicId;
        if(isset($DTO->created_at)) $model->created_at= DateTimeSetter::setDateTime($DTO->created_at);
        if(isset($DTO->updated_at)) $model->updated_at= DateTimeSetter::setDateTime($DTO->updated_at);
        if(isset($DTO->fecha_eliminado)) $model->fecha_eliminado= DateTimeSetter::setDateTime($DTO->fecha_eliminado);
        
        return $model;
    }

    /**
     * Map model to dto
     * @param CanalVentaListaPrecio|stdClass $model
     * @return CanalVentaListaPrecioDTO|null
     */
    public function reverse($model)
    {
        $dto= new CanalVentaListaPrecioDTO();
        if(isset($model->publicId))$dto->publicId=$model->publicId;
        $dto->listaPid=$model->listaPid;
        $dto->canalventaPid= $model->canalventaPid;
        if(isset($model->created_at)) $dto->created_at=DateTimeSetter::setDateTime($model->created_at);

        return $dto;
    }

}
