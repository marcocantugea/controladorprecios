<?php

namespace App\Mappers;

use App\Contractors\IMapper;
use App\Contractors\Models\Categoria;
use App\DTOs\CategoriaDTO;
use DateTime;

class CategoriaMapper implements IMapper
{
    public function map($DTO)
    {
        $categoria= new Categoria();
        
        $categoria->publicId=(empty($DTO->publicId)) ? null : $DTO->publicId;
        $categoria->nombre= $DTO->nombre;
        $categoria->created_at=(empty($DTO->created_at)) ? null : new DateTime($DTO->created_at);
        $categoria->updated_at=(empty($DTO->updated_at)) ? null : new DateTime($DTO->updated_at);
        $categoria->fecha_eliminado=(empty($DTO->fecha_eliminado)) ? null : new DateTime($DTO->fecha_eliminado);
        $categoria->esSubCategoria=(empty($DTO->esSubcategoria)) ? false : boolval($DTO->esSubcategoria);
        return $categoria;
    }

    public function reverse($model)
    {
        $dateCreate=(empty($model->created_at)) ? null : new DateTime($model->created_at);
        $dateUpdated=(empty($model->updated_at)) ? null : new DateTime($model->updated_at);
        $fechaEliminado=(empty($model->fecha_eliminado)) ? null : new DateTime( $model->fecha_eliminado);
        return new CategoriaDTO($model->nombre,
                                (empty($model->activo)) ? true : boolval($model->activo),
                                $dateCreate,
                                $dateUpdated,
                                $fechaEliminado,
                                (empty($model->publicId)) ? null : $model->publicId,
                                esSubCategoria:(isset($model->esSubcategoria)) ? boolval($model->esSubcategoria) : false
                            );
    }
}
