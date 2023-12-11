<?php

namespace App\Services;

use App\Contractors\IMapper;
use App\Contractors\Models\Usuario;
use App\Contractors\Repositories\IUsuariosRepository;
use App\Contractors\Services\IUsuariosService;
use App\DTOs\UsuarioDTO;

class UsuariosService implements IUsuariosService {
    
    private IUsuariosRepository $usuariosRepository;
    private IMapper $mapper;

    public function __construct(IUsuariosRepository $usuarioRepository, IMapper $usuarioMapper) {
        $this->usuariosRepository=$usuarioRepository;
        $this->mapper=$usuarioMapper;
    }

    public function addUsuario(UsuarioDTO $usuario)
    {
        try {
            $model= $this->mapper->map($usuario);
            $model->hash= password_hash($usuario->password,PASSWORD_DEFAULT);
            $this->usuariosRepository->add($model);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function updateUsuario(UsuarioDTO $usuario)
    {
        try {
            $model=$this->mapper->map($usuario);
            $this->usuariosRepository->update($usuario);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function activateUsuario($id)
    {
        try {
            $this->usuariosRepository->activateUsuario($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function deActivateUsuario($id)
    {
        try {
            $this->usuariosRepository->deActivateUsuario($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function deleteUsuario($id)
    {
        try {
            $this->usuariosRepository->delete($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getUsuarios(array $searchParams,int $limit=500,int $offset=0){

        $fiedlsLikeOperator=[
            "user"
        ];
        $productoModel=get_class_vars(Usuario::class);
        $filterSearhParams=[];
        foreach ($searchParams as $key => [$value,$operator]) {
            if(!in_array($key,array_keys($productoModel))) continue;
            if(in_array($key,$fiedlsLikeOperator)) $operator='like';
            $filterSearhParams+=[$key=>[$value,$operator]];
        }

        $usuariosFound=$this->usuariosRepository->getUsuarios($filterSearhParams,$limit,$offset);

        $usuariosDTOs=[];
        foreach ($usuariosFound as $value) {
            $usuarioDTO=$this->mapper->reverse($value);
            array_push($usuariosDTOs,$usuarioDTO);
        }

        return $usuariosDTOs;
    }

}