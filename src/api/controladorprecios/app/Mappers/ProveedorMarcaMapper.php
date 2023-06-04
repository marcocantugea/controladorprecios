<?php

namespace App\Mappers;

use App\Contractors\IMapper;
use App\Contractors\Models\Proveedor;
use App\Contractors\Models\ProveedorMarca;
use App\DTOs\MarcaDTO;
use App\DTOs\ProveedorDTO;
use App\DTOs\ProveedorMarcaDTO;
use stdClass;
use DateTime;

class ProveedorMarcaMapper implements IMapper
{
    /**
     * Get a model
     * @param ProveedorMarcaDTO|stdClass $DTO
     * @return ProveedorMarca|null
     */
    public function map($DTO)
    {
        if(!isset($DTO->marcaId)) return null;
        if(!isset($DTO->proveedorId)) return null;
        $model= new ProveedorMarca($DTO->marcaId,$DTO->proveedorId);
        $model->id= $DTO->id ?? null;
        $model->activo=(isset($DTO->activo)) ? boolval($DTO->activo) : false;
        $model->created_at= (isset($DTO->created_at)) ? $this->setDateTime($DTO->created_at) : null;
        $model->updated_at= (isset($DTO->updated_at)) ? $this->setDateTime($DTO->updated_at) : null;
        $model->fecha_eliminado= (isset($DTO->fecha_eliminado)) ? $this->setDateTime($DTO->fecha_eliminado) : null;
       
        return $model;
    }

    /** 
     * Get a DTO
     * @param ProveedorMarca|stdClass $model
     * @return ProveedorMarcaDTO|null
    */
    public function reverse($model)
    {
        if(isset($model->marcaPublicId) && isset($model->proveedorPublicId)){
            $marcaStr= (isset($model->marca) && is_string($model->marca)) ? $model->marca : "";
            return new ProveedorMarcaDTO($model->proveedorPublicId,$model->marcaPublicId,$marcaStr);
        }

        if(!isset($model->marca)) return null;
        if(!isset($model->marca->publicId)) return null;
        if(!isset($model->proveedor)) return null;
        if(!isset($model->proveedor->publicId)) return null;
        
        $dto= new ProveedorMarcaDTO($model->proveedor->publicId,$model->marca->publicId);
        $dto->marca->marca=$model->marca->marca ?? "";
        $dto->marca->activo=(isset($model->marca->activo)) ? boolval($model->marca->activo) : false;

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
