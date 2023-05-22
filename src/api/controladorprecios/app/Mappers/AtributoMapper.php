<?php

namespace App\Mappers;

use App\Contractors\IMapper;
use App\Contractors\Models\Atributo;
use App\DTOs\AtributoDTO;
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
        
        if(isset($DTO->activo)){
            $atributo->activo=boolval($DTO->activo);
        }

        if($DTO->created_at instanceof DateTime){
            $atributo->created_at=$DTO->created_at;
        }elseif (is_string($DTO->created_at)) {
            $atributo->created_at=new DateTime($DTO->created_at);
        }elseif ($DTO->created_at instanceof stdClass) {
            $atributo->created_at=new DateTime($DTO->created_at->date);
        }else{
            $atributo->created_at=null;
        }

        if($DTO->updated_at instanceof DateTime){
            $atributo->updated_at=$DTO->updated_at;
        }elseif (is_string($DTO->updated_at)) {
            $atributo->updated_at=new DateTime($DTO->updated_at);
        }elseif ($DTO->updated_at instanceof stdClass) {
            $atributo->updated_at=new DateTime($DTO->updated_at->date);
        }else{
            $atributo->updated_at=null;
        }

        if($DTO->fecha_eliminado instanceof DateTime){
            $atributo->fecha_eliminado=$DTO->fecha_eliminado;
        }elseif (is_string($DTO->fecha_eliminado)) {
            $atributo->fecha_eliminado=new DateTime($DTO->fecha_eliminado);
        }elseif ($DTO->fecha_eliminado instanceof stdClass) {
            $atributo->fecha_eliminado=new DateTime($DTO->fecha_eliminado->date);
        }else{
            $atributo->fecha_eliminado=null;
        }

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
        
        if (isset($model->created_at)) {
            if ($model->created_at instanceof DateTime) {
                $dto->created_at = $model->created_at;
            } elseif (is_string($model->created_at)) {
                $dto->created_at = new DateTime($model->created_at);
            } elseif ($model->created_at instanceof stdClass) {
                $dto->created_at = new DateTime($model->created_at->date);
            } else {
                $dto->created_at = null;
            }
        }

        if (isset($model->updated_at)) {
            if ($model->updated_at instanceof DateTime) {
                $dto->updated_at = $model->updated_at;
            } elseif (is_string($model->updated_at)) {
                $dto->updated_at = new DateTime($model->updated_at);
            } elseif ($model->updated_at instanceof stdClass) {
                $dto->updated_at = new DateTime($model->updated_at->date);
            } else {
                $dto->updated_at = null;
            }
        }

        if (isset($model->fecha_eliminado)) {
            if ($model->fecha_eliminado instanceof DateTime) {
                $dto->fecha_eliminado = $model->fecha_eliminado;
            } elseif (is_string($model->fecha_eliminado)) {
                $dto->fecha_eliminado = new DateTime($model->fecha_eliminado);
            } elseif ($model->fecha_eliminado instanceof stdClass) {
                $dto->fecha_eliminado = new DateTime($model->fecha_eliminado->date);
            } else {
                $dto->fecha_eliminado = null;
            }
        }

        $dto->esSubatributo=(empty($model->esSubatributo)) ? false : boolval($model->esSubatributo);

        return $dto;
    }
}
