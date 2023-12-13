<?php

namespace App\Services;

use App\Contractors\IMapper;
use App\Contractors\Repositories\IRolesRepository;
use App\Contractors\Repositories\IRolUsuarioRepository;
use App\Contractors\Repositories\IUsuariosRepository;
use App\Contractors\Services\IRolUsuarioService;
use App\DTOs\RolUsuarioDTO;
use Exception;

class RolUsuarioService implements IRolUsuarioService
{
    private IRolUsuarioRepository $repository;
    private IUsuariosRepository $usuarioRepository;
    private IRolesRepository $rolRepository;
    private IMapper $mapper;

    public function __construct(IRolUsuarioRepository $repository, IMapper $mapper,IUsuariosRepository $usuarioReposiotry, IRolesRepository $rolRepository) {
        $this->repository = $repository;
        $this->mapper=$mapper;
        $this->usuarioRepository=$usuarioReposiotry;
        $this->rolRepository=$rolRepository;
    }
    
    /**
     * 
     */
    public function addRolUsuario(RolUsuarioDTO $dto)
    {
        try {
            if(empty($dto->usuarioPid) && empty($dto->rolPid)) throw new Exception('invalid usuario and rol ids');
            $model=$this->mapper->map($dto);
            $model->usuarioId= $this->usuarioRepository->getById($dto->usuarioPid)->id;
            $model->rolId= $this->rolRepository->getById($dto->rolPid)->id;

            $publicId= $this->repository->add($model);

            return $publicId;

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getRolUsuarioById(string $pid)
    {
        try {
            if(empty($pid)) throw new Exception('invalid id');
            $model=$this->repository->getById($pid);
            $dto=$this->mapper->reverse($model);

            return $dto;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function deleteRolUsuario(string $pid)
    {
        try {
            if(empty($pid)) throw new Exception('invalid id');
            $this->repository->delete($pid);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getRolByUsuarioId(string $usuarioPid)
    {
        try {
            if(empty($usuarioPid)) throw new Exception('invalid id');
            $model=$this->repository->getRolByUserId($usuarioPid);
            $dto=$this->mapper->reverse($model);
            return $dto;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}
