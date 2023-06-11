<?php

namespace App\Mappers;

use App\Contractors\IMapper;
use App\Contractors\Models\ProveedorProducto;
use App\DTOs\ProveedorProductoDTO;
use App\Helpers\DateTimeSetter;
use stdClass;
use DateTime;

class ProveedorProductoMapper implements IMapper{

    /**
     * Map to model
     * @param ProveedorProductoDTO|stdClass $DTO
     * @return ProveedorProducto|null
     */
    public function map($DTO)
    {
        if(!isset($DTO->productoId) || !isset($DTO->productoId)) return null;
        $model=new ProveedorProducto($DTO->productoId,$DTO->proveedorId);
        $model->id=$DTO->id ?? null;
        $model->activo = (isset($DTO->activo)) ? boolval($DTO->activo) : false;
        $model->created_at= (isset($DTO->created_at)) ? DateTimeSetter::setDateTime($DTO->created_ad) : null;
        $model->updated_at= (isset($DTO->updated_at)) ? DateTimeSetter::setDateTime($DTO->updated_at) : null;
        $model->fecha_eliminado= (isset($DTO->fecha_eliminado)) ? DateTimeSetter::setDateTime($DTO->fecha_eliminado) : null;
        $model->proveedorPublicId=$DTO->proveedorPublicId ?? null;
        $model->productoPublicId=$DTO->productoPublicId ?? null;

        return $model;

    }

    /**
     * Mato to get DTO
     * @param ProveedorProducto|stdClass $model
     * @return ProveedorProductoDTO|null
     */
    public function reverse($model)
    {
        if(!isset($model->proveedorPublicId) || !isset($model->productoPublicId)) return null;
        $dto= new ProveedorProductoDTO($model->proveedorPublicId,$model->productoPublicId);
        $dto->codigo= $model->codigo ?? null;

        return $dto;
    }

}