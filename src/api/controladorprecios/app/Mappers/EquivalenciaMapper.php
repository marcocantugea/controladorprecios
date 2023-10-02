<?php

namespace App\Mappers;

use App\Contractors\IMapper;
use App\Contractors\Models\Equivalencia;
use App\DTOs\EquivalenciaDTO;
use App\Helpers\DateTimeSetter;
use stdClass;

class EquivalenciaMapper implements IMapper
{
    /**
     * Map to model Equivalencia
     * @param EquivalenciaDTO|stdClass $DTO
     * @return Equivalencia|null
     */
    public function map($DTO)
    {
        
        if(empty($DTO->productoId) || empty($DTO->productoIdEqu)) return null;
        $model=new Equivalencia($DTO->productoId,$DTO->productoIdEqu);
        if(isset($DTO->id) && !empty($DTO->id)) $model->id= $DTO->id;
        $model->publicId = $DTO->publicId ?? null;
        $model->productoPublicId = $DTO->productoPublicId ?? null;
        $model->productoPublicIdEqu = $DTO->productoPublicIdEqu ?? null;
        if(isset($DTO->created_at))$model->created_at = DateTimeSetter::setDateTime($DTO->created_at);
        if(isset($DTO->updated_at))$model->updated_at = DateTimeSetter::setDateTime($DTO->updated_at);
        if(isset($DTO->fecha_elimiando))$model->fecha_elimiando = DateTimeSetter::setDateTime($DTO->fecha_elimiando);

        return $model;

    }

    /**
     * Map to DTO
     * @param Equivalencia|stdClass $model
     * @return EquivalenciaDTO|null
     */
    public function reverse($model)
    {
        if(empty($model->productoPublicId) || empty($model->productoPublicIdEqu)) return null;
        $dto=new EquivalenciaDTO($model->productoPublicId,$model->productoPublicIdEqu);
        $dto->publicId=$model->publicId ?? null;
        if(isset($model->productoId)) $dto->productoId= $model->productoId;
        if(isset($model->productoIdEqu)) $dto->productoIdEqu= $model->productoIdEqu;

        return $dto;

    }
}
