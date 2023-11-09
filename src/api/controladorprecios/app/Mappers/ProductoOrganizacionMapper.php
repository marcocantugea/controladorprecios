<?php

namespace App\Mappers;

use App\Contractors\IMapper;
use App\Contractors\Models\ProductoOrganizacion;
use App\DTOs\ProductoOrganizacionDTO;
use stdClass;

class ProductoOrganizacionMapper implements IMapper
{

    private ProductoMapper $productoMapper;

    public function __construct() {
        $this->productoMapper=new ProductoMapper();
    }

    /**
     * Map the dto to a model
     * @param ProductoOrganizacionDTO|stdClass
     * @return ProductoOrganizacion|null
     */
    public function map($DTO){
        $model= new ProductoOrganizacion();
        $model->publicId=(empty($DTO->publicId))? null :$DTO->publicId;
        $model->organizacionId=$DTO->organizacionId;
        if(isset($DTO->productoId)) $model->productoId=$DTO->productoId;
        if(isset($DTO->producto)) $model->producto = $this->productoMapper->map($DTO->producto);
        if(isset($DTO->created_at)) $model->created_at=$DTO->created_at;
        if(isset($DTO->updated_at)) $model->created_at=$DTO->updated_at;
        if(isset($DTO->fecha_eliminado)) $model->fecha_eliminado=$DTO->fecha_eliminado;
    }

    /**
     * @param ProductoOrganizacion|stdClass
     * @return ProductoOrganizacionDTO|null
     */
    public function reverse($model){

        $dto = new ProductoOrganizacionDTO($model->organizacionId);
        if(isset($model->publicId))$dto->publicId=$model->publicId;
        if(isset($model->producto)) $dto->producto=$this->productoMapper->reverse($model);

        return $dto;
    }
}
