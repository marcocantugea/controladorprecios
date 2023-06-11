<?php

namespace App\Mappers;

use App\Contractors\IMapper;
use App\Contractors\Models\Costo;
use App\Contractors\Models\Producto;
use App\Contractors\Models\Proveedor;
use App\DTOs\CostoDTO;
use stdClass;
use DateTime;

class CostoMapper implements IMapper
{
    
    /**
     * Map to Model
     * @param CostoDTO|stdClass $DTO
     * @return Costo|null
     */
    public function map($DTO)
    {
        if(!property_exists($DTO,'proveedorId') || !property_exists($DTO,'costo') || !property_exists($DTO,'productoId') ) return null;
        $model= new Costo($DTO->proveedorId,$DTO->productoId,$DTO->costo);
        $model->id= $DTO->id ?? null;
        $model->publicId= $DTO->publicId ?? null;
        $model->activo = (property_exists($DTO,'activo')) ? boolval($DTO->activo) : false;
        $model->created_at =(property_exists($DTO,'created_at')) ? $this->setDateTime($DTO->created_at) : null;
        $model->updated_at = (property_exists($DTO,'updated_at')) ? $this->setDateTime($DTO->updated_at) : null;
        $model->fecha_eliminado = (property_exists($DTO,'fecha_eliminado')) ? $this->setDateTime($DTO->fecha_eliminado) : null;
        $model->expira_en = (property_exists($DTO,'expiraEn')) ? $this->setDateTime($DTO->expiraEn) : null;
        $model->productoPublicId = $DTO->productoPublicId ?? null;
        $model->proveedorPublicId = $DTO->proveedorPublicId ?? null;
        
        if(!isset($model->proveedor) 
            && isset($model->proveedorPublicId) 
            && property_exists($DTO,'nombreCorto') 
            && property_exists($DTO,'codigoProveedor')
            && !empty($DTO->codigoProveedor) 
            && !empty($DTO->nombreCorto)
        ){
            $model->proveedor= new Proveedor($DTO->codigoProveedor,$DTO->nombreCorto,publicId:$DTO->proveedorPublicId);
            $model->proveedor->id = $DTO->proveedorId ?? null;
        }

        if(
            !isset($model->producto)
            && isset($model->productoPublicId)
            && isset($DTO->nombreProducto)
            && isset($DTO->productoId)
        ){
            $model->producto= new Producto();
            $model->producto->publicId= $model->productoPublicId;
            $model->producto->nombre= $DTO->nombreProducto ?? null;
            $model->producto->id = $DTO->productoId ?? null;
        }

        return $model;
    }

    /**
     * Map to DTO
     * @param Costo|StdClass $model
     * @return CostoDTO|null;
     */
    public function reverse($model)
    {
        if(!property_exists($model,'proveedorPublicId') || !property_exists($model,'productoPublicId') || !property_exists($model,'costo') ) return null;
        
        $nombreProveedor=(property_exists($model,'nombreCorto')) ? $model->nombreCorto: null;
        if(property_exists($model,'proveedor')) $nombreProveedor = $model->proveedor?->nombreCorto;

        $nombreProducto=(property_exists($model,'nombreProducto')) ? $model->nombreProducto :null;
        if(property_exists($model,'producto')) $nombreProducto=$model->producto?->nombre;

        $dto= new CostoDTO($model->proveedorPublicId,$model->productoPublicId,$model->costo);
        $dto->codigoProveedor=(isset($model->codigoProveedor))? $model->codigoProveedor :  $model->proveedor?->codigo ?? null;
        $dto->nombreCorto=$nombreProveedor;
        $dto->nombreProducto= $nombreProducto;
        $dto->expiraEn=(isset($model->expira_en)) ? $this->setDateTime($model->expira_en) : null;
        $dto->created_at=(isset($model->created_at)) ? $this->setDateTime($model->created_at) : null;
        $dto->fecha_eliminado=(isset($model->fecha_eliminado)) ? $this->setDateTime($model->fecha_eliminado) : null;
        $dto->proveedorId = $model->proveedorId ?? null;
        $dto->productoId = $model->productoId ?? null;
        $dto->publicId = $model->publicId ?? null;

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
