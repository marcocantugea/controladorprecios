<?php

namespace App\Mappers;

use App\Contractors\IMapper;
use App\Contractors\Models\Marca;
use App\DTOs\MarcaDTO;
use App\Helpers\DateTimeSetter;
use \DateTime;
use stdClass;


class MarcaMapper implements IMapper
{
    /**
     * @return Marca|null
     */
    public function map($DTO)
    {
        if(!isset($DTO->marca)) return null;
        $marca=new Marca($DTO->marca,publicId:$DTO->publicId,activo:$DTO->activo);
        if(isset($DTO->created_at)) $marca->created_at=DateTimeSetter::setDateTime($DTO->created_at);
        if(isset($DTO->updated_at)) $marca->updated_at=DateTimeSetter::setDateTime($DTO->updated_at);
        if(isset($DTO->fecha_eliminado)) $marca->fecha_eliminado=DateTimeSetter::setDateTime($DTO->fecha_eliminado);
        return $marca;
    }

    /**
     * @return MarcaDTO|null
     */
    public function reverse($model)
    {
        if(!isset($model->marca)) return null;
        $dto=new MarcaDTO($model->marca);
        if(isset($model->publicId)) $dto->publicId=$model->publicId;
        if(isset($model->activo)) $dto->activo=$model->activo;
        return $dto;
    }
}
