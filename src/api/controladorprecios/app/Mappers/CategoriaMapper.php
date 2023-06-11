<?php

namespace App\Mappers;

use App\Contractors\IMapper;
use App\Contractors\Models\Categoria;
use App\DTOs\CategoriaDTO;
use App\Helpers\DateTimeSetter;
use DateTime;

class CategoriaMapper implements IMapper
{
    public function map($DTO)
    {
        $categoria= new Categoria();
        
        $categoria->publicId=(empty($DTO->publicId)) ? null : $DTO->publicId;
        $categoria->nombre= $DTO->nombre;
        if(isset($DTO->created_at)) $categoria->created_at=DateTimeSetter::setDateTime($DTO->created_at);
        if(isset($DTO->updated_at)) $categoria->updated_at=DateTimeSetter::setDateTime($DTO->updated_at);
        if(isset($DTO->fecha_eliminado)) $categoria->fecha_eliminado=DateTimeSetter::setDateTime($DTO->fecha_eliminado);
        $categoria->esSubcategoria=(empty($DTO->esSubcategoria)) ? false : boolval($DTO->esSubcategoria);
        return $categoria;
    }

    public function reverse($model)
    {
        $dto=new CategoriaDTO($model->nombre,(isset($model->activo)) ? boolval($model->activo) : true);
        $dto->esSubcategoria=(isset($model->esSubcategoria)) ? boolval($model->esSubcategoria) : false;
        $dto->publicId = $model->publicId ?? null;
        if(isset($model->created_at)) $dto->created_at= DateTimeSetter::setDateTime($model->created_at);
        if(isset($model->updated_at)) $dto->updated_at= DateTimeSetter::setDateTime($model->updated_at);
        if(isset($model->fecha_eliminado)) $dto->fecha_eliminado= DateTimeSetter::setDateTime($model->fecha_eliminado);
        
        return $dto;
    }
}
