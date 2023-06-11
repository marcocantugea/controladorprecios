<?php

namespace App\Mappers;

use App\Contractors\IMapper;
use App\Contractors\Models\Usuario;
use App\DTOs\UsuarioDTO;
use App\Helpers\DateTimeSetter;
use stdClass;
use DateTime;

class UsuarioMapper implements IMapper
{
    /**
     * @return Usuario|null
     */
    public function map($DTO)
    {
        if(!isset($DTO->user)) return null;
        $usuarioModel=new Usuario($DTO->user);
        $usuarioModel->email=(!isset($DTO->email)) ? null : $DTO->email;
        $usuarioModel->publicId=(!isset($DTO->publicId)) ? null : $DTO->publicId;
        $usuarioModel->active=(!isset($DTO->active)) ? false : boolval($DTO->active);
        $usuarioModel->id=(!isset($DTO->id)) ? null : $DTO->id;
        $usuarioModel->created_at=(!isset($DTO->created_at)) ? null : DateTimeSetter::setDateTime($DTO->created_at);
        $usuarioModel->updated_at=(!isset($DTO->updated_at)) ? null : DateTimeSetter::setDateTime($DTO->updated_at);
        $usuarioModel->deleted_at=(!isset($DTO->deleted_at)) ? null : DateTimeSetter::setDateTime($DTO->deleted_at);
        $usuarioModel->hash=(!isset($DTO->hash)) ? null : $DTO->hash;

        return $usuarioModel;
    }

    public function reverse($model)
    {
        if(!isset($model->user)) return null;
        $usuarioDTO= new UsuarioDTO($model->user,"");
        $usuarioDTO->publicId= (!isset($model->publicId)) ? null : $model->publicId;
        $usuarioDTO->email=(!isset($model->email)) ? null : $model->email;
        $usuarioDTO->active=(!isset($model->active)) ? false : boolval($model->active);
        $usuarioDTO->created_at=(!isset($model->created_at)) ? null : DateTimeSetter::setDateTime($model->created_at);
        $usuarioDTO->updated_at=(!isset($model->updated_at)) ? null : DateTimeSetter::setDateTime($model->updated_at);
        $usuarioDTO->deleted_at=(!isset($model->deleted_at)) ? null : DateTimeSetter::setDateTime($model->deleted_at);

        return $usuarioDTO;
    }

}
