<?php

namespace App\Mappers;

use App\Contractors\IMapper;
use App\DTOs\OrganizacionDTO;
use App\Models\Organizacion;
use stdClass;

class OrganizacionMapper implements IMapper
{
    /**
     * Map a DTO to Model
     * @param OrganizacionDTO|stdClass $DTO
     * @return Organizacion|null
     */
    public function map($DTO){

        try {

            $model= new Organizacion();
            $model->nombre=$DTO->nombre;
            $model->descripcion=$DTO->descripcion;
            $model->codigo=$DTO->codigo;
            $model->created_at=(isset($DTO->created_at)) ? $DTO->created_at : null;
            $model->updated_at=(isset($DTO->updated_at)) ? $DTO->updated_at : null;
            $model->fecha_eliminado=(isset($DTO->fecha_eliminado)) ? $DTO->fecha_eliminado : null;
            return $model;

        } catch (\Throwable $th) {
            return null;
        }
    }

    /**
     * Map Model to DTO
     * @param Organizacion|stdClass $model
     * @return OrganizacionDTO|null
     */
    public function reverse($model){
        try {
            $DTO= new OrganizacionDTO();
            if(isset($model->publicId)) $DTO->publicId=$model->publicId;
            $DTO->nombre= $model->nombre;
            $DTO->descripcion=$model->descripcion;
            $DTO->codigo=$model->codigo;

            return $DTO;
        } catch (\Throwable $th) {
            return null;
        }

    }
}
