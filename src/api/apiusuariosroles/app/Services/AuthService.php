<?php

namespace App\Services;

use App\Contractors\IMapper;
use App\Contractors\Repositories\IUsuariosRepository;
use App\Contractors\Services\IAuthService;
use App\DTOs\UsuarioDTO;
use Exception;

class AuthService implements IAuthService
{
    private IUsuariosRepository $userRepository;
    private IMapper $mapper;

    public function __construct(IUsuariosRepository $userRepository,IMapper $mapper) {
        $this->userRepository=$userRepository;
        $this->mapper=$mapper;
    }

    public function AuthenticatedUser(string $user, string $password)
    {
        try {
            if(empty($user) || empty($password)) throw new Exception("invalid parametes to authenticate");
        $userObj = $this->userRepository->getUsuario($user);
        if(empty($userObj)) throw new Exception("Invalid user");

        if(!password_verify($password,$userObj->hash)) throw new Exception("invalid password");

        $acciones=$this->userRepository->getAcciones($userObj->publicId);
        $accionesList=[];
        foreach ($acciones as $accion) {
            array_push($accionesList,$accion->accion);
        }
        $userObj->actions=$accionesList;

        $userObj->rolPid=$this->userRepository->getUserRol($userObj->publicId)->publicId;

        return $userObj;

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    function AddUser(UsuarioDTO $usuario){
        try {
            $usuarioModel=$this->mapper->map($usuario);
            $this->userRepository->add($usuarioModel);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    function updateUserPassword(UsuarioDTO $usuario){
        try {
            $usuarioModel=$this->mapper->map($usuario);
            $this->userRepository->update($usuarioModel);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    function activateUser($id){
        try {
            $this->userRepository->activateUsuario($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
