<?php

namespace App\Mappers;

use App\Contractors\IMapper;
use App\Contractors\Models\Marca;
use App\DTOs\MarcaDTO;
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
        if(isset($DTO->created_at)) $marca->created_at=$this->setDateTime($DTO->created_at);
        if(isset($DTO->updated_at)) $marca->updated_at=$this->setDateTime($DTO->updated_at);
        if(isset($DTO->fecha_eliminado)) $marca->fecha_eliminado=$this->setDateTime($DTO->fecha_eliminado);
        return $marca;
    }

    /**
     * @return MarcaDTO|null
     */
    public function reverse($model)
    {
        if(!isset($model->marca)) return null;
        return new MarcaDTO($model->marca,$model->publicId,$model->activo);
    }

    private function setDateTime($dateItem){
        if($dateItem==null) return null;
        if(is_string($dateItem)) return new DateTime($dateItem);
        if($dateItem instanceof DateTime) return $dateItem;
        if($dateItem instanceof stdClass) return new DateTime($dateItem->date);
        return null;
    }
}
