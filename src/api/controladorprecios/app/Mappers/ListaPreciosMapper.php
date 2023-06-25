<?php

namespace App\Mappers;

use App\Contractors\IMapper;
use App\Contractors\Models\ListaPrecios;
use App\DTOs\ListaPreciosDTO;
use App\Helpers\DateTimeSetter;
use Exception;
use stdClass;

class ListaPreciosMapper implements IMapper{

    /**
     * Will map a dto to model
     * @param ListaPreciosDTO|stdClass $DTO
     * @return ListaPrecios|null
     */
    public function map($DTO)
    {
        if(!isset($DTO->nombre) || !isset($DTO->descripcion) || !isset($DTO->fecha_inicio) || !isset($DTO->fecha_expira))
            throw new Exception("missing parameters");

        $model= new ListaPrecios($DTO->nombre,$DTO->descripcion,$DTO->fecha_inicio,$DTO->fecha_expira);

        $model->id=$DTO->id ?? null;
        $model->publicId=$DTO->publicId ?? null;
        $model->created_at= DateTimeSetter::setDateTime($DTO->create_function);
        $model->updated_at= DateTimeSetter::setDateTime($DTO->updated_at);
        $model->fecha_eliminado= DateTimeSetter::setDateTime($DTO->fecha_eliminado);
        $model->activo=boolval($DTO->activo);
        $model->margenUtilidad=$DTO->margenUtilidad ?? 0;
        
        return $model;
    }

    /**
     * Will map model to dto
     * @param ListaPrecios|stdClass $model
     * @return ListaPrecios|null
     */
    public function reverse($model)
    {
        if(!isset($model->nombre) || !isset($model->descripcion) || !isset($model->fecha_inicio) || !isset($model->fecha_expira))
            throw new Exception("missing parameters");

        $dto= new ListaPreciosDTO($model->nombre,$model->descripcion,$model->fecha_inicio,$model->fecha_expira);

        $dto->publicId=$model->publicId ?? null;
        $dto->created_at= DateTimeSetter::setDateTime($model->create_function);
        $dto->updated_at= DateTimeSetter::setDateTime($model->updated_at);
        $dto->fecha_eliminado= DateTimeSetter::setDateTime($model->fecha_eliminado);
        $dto->activo=boolval($model->activo);
        $dto->margenUtilidad=$model->margenUtilidad ?? 0;
        
        return $model;
    }
}