<?php

namespace App\Mappers;

use App\Contractors\IMapper;
use App\Contractors\Models\Categoria;
use App\DTOs\CategoriaDTO;

class CategoriaMapper implements IMapper
{
    public function map($DTO)
    {
        $categoria= new Categoria();
        
        $categoria->publicId=(empty($DTO->publicId)) ? null : $DTO->publicId;
        $categoria->nombre= $DTO->nombre;
        $categoria->created_at=(empty($DTO->created_at)) ? null : $DTO->created_at;
        $categoria->updated_at=(empty($DTO->updated_at)) ? null : $DTO->updated_at;
        $categoria->fecha_eliminado=(empty($DTO->fecha_eliminado)) ? null : $DTO->fecha_eliminado;

        return $categoria;
    }

    public function reverse($model)
    {
        return new CategoriaDTO($model->nombre,
                                (empty($model->activo)) ? true : $model->activo,
                                (empty($model->created_at)) ? null : $model->created_at,
                                (empty($model->updated_at)) ? null : $model->updated_at,
                                (empty($model->fecha_eliminado)) ? null : $model->fecha_eliminado,
                                (empty($model->publicId)) ? null : $model->publicId
                            );
    }
}
