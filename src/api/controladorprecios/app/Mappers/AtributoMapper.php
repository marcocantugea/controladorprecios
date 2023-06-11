<?php

namespace App\Mappers;

use App\Contractors\IMapper;
use App\Contractors\Models\Atributo;
use App\DTOs\AtributoDTO;
use App\Helpers\DateTimeSetter;
use \DateTime;
use stdClass;

class AtributoMapper implements IMapper
{
    /**
     * @return Atributo 
     */
    public function map($DTO)
    {
        $atributo = new Atributo($DTO->atributo);
        $atributo->publicId=(empty($DTO->publicId)) ? null : $DTO->publicId;
        
        if(isset($DTO->activo)) $atributo->activo=boolval($DTO->activo);
        if(isset($DTO->created_at)) $atributo->created_at= DateTimeSetter::setDateTime($DTO->created_at);
        if(isset($DTO->updated_at)) $atributo->updated_at= DateTimeSetter::setDateTime($DTO->updated_at);
        if(isset($DTO->fecha_eliminado)) $atributo->fecha_eliminado= DateTimeSetter::setDateTime($DTO->fecha_eliminado);
        $atributo->esSubatributo=(empty($DTO->esSubatributo)) ? false : boolval($DTO->esSubatributo);
        return $atributo;
    }

    /**
     * @return AtributoDTO
     */
    public function reverse($model)
    {
        $dto=new AtributoDTO($model->atributo);
        $dto->publicId=(empty($model->publicId)) ? null : $model->publicId;
        
        if(isset($model->activo)){
            $dto->activo=boolval($model->activo);
        }
        
        if (isset($model->created_at)) $dto->created_at = DateTimeSetter::setDateTime($model->created_at);
        if (isset($model->updated_at)) $dto->updated_at = DateTimeSetter::setDateTime($model->updated_at);
        if (isset($model->fecha_eliminado)) $dto->fecha_eliminado = DateTimeSetter::setDateTime($model->fecha_eliminado);
        $dto->esSubatributo=(empty($model->esSubatributo)) ? false : boolval($model->esSubatributo);

        return $dto;
    }
}
