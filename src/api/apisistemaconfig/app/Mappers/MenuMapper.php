<?php 

namespace App\Mappers;

use App\Contractors\IMapper;
use App\Contractors\Models\Menu;
use App\DTOs\MenuDTO;
use App\Helpers\DateTimeSetter;
use stdClass;

final class MenuMapper implements IMapper
{
    
    /**
     * map dto to a model
     * @param MenuDTO|stdClass $DTO
     * @return Menu|null
     */
    public function map($DTO)
    {
        if(!isset($DTO->nombre) || !isset($DTO->display)) return null;
        $model= new Menu();
        $model->nombre=$DTO->nombre;
        $model->display=$DTO->display;
        if(isset($DTO->id)) $model->id=$DTO->id;
        if(isset($DTO->publicId)) $model->publicId=$DTO->publicId;
        if(isset($DTO->activo)) $model->activo=$DTO->activo;
        if(isseT($DTO->essubmenu)) $model->essubmenu=$DTO->essubmenu;
        if(isset($DTO->orden)) $model->orden=$DTO->orden;
        if(isset($DTO->submenuId)) $model->submenuId=$DTO->submenuId;
        if(isset($DTO->created_at)) $model->created_at=DateTimeSetter::setDateTime($DTO->created_at);
        if(isset($DTO->updated_at)) $model->updated_at=DateTimeSetter::setDateTime($DTO->updated_at);
        if(isset($DTO->fecha_eliminado)) $model->fecha_eliminado=DateTimeSetter::setDateTime($DTO->fecha_eliminado);
        if(isset($DTO->accion)) $model->accion=$DTO->accion;

        return $model;
    }

    /**
     * map model to dto
     * @param Menu|stdClass $model
     * @return MenuDTO|null
     */
    public function reverse($model)
    {
        if(!isset($model->nombre) || !isset($model->display)) return null;
        $dto=new MenuDTO();
        $dto->nombre=$model->nombre;
        $dto->display=$model->display;
        if(isset($model->publicId)) $dto->publicId=$model->publicId;
        if(isset($model->activo)) $dto->activo=$model->activo;
        if(isset($model->essubmenu)) $dto->essubmenu=$model->essubmenu;
        if(isset($model->orden)) $dto->orden=$model->orden;
        if(isset($model->accion)) $dto->accion=$model->accion;

        return $dto;
    }
}
