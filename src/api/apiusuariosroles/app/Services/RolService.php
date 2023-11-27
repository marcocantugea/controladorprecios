<?php

namespace App\Services;

use App\Contractors\IMapper;
use App\Contractors\Models\Rol;
use App\Contractors\Repositories\IRolesRepository;
use App\Contractors\Services\IRolService;
use App\DTOs\RolDTO;
use Exception;

class RolService implements IRolService
{
    private IRolesRepository $repository;
    private IMapper $mapper;

    public function __construct(IRolesRepository $roles,IMapper $mapper) {
        $this->repository=$roles;
        $this->mapper=$mapper;
    }

    /**
     * add Rol
     * @param RolDTO $dto
     * @return string|null
     */
    public function addRole($dto){
        try {
            $model=$this->mapper->map($dto);
            $pid=$this->repository->add($model);
            return $pid;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * update model
     * @param RolDTO $dto
     * @return void
     */
    public function updateRol($dto){
        try {
            if(empty($dto->publicId)) throw new Exception('invalid Id');
            $model=$this->mapper->map($dto);
            $this->repository->update($model);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * delete model
     * @param string $pid
     * @return void
     */
    public function deleteRol($pid){
        try {
            if(empty($pid)) throw new Exception('invalid Id');
            $this->repository->delete($pid);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    

    /**
     * Get rol by id
     * @param string $pid
     * @return RolDTO|null;
     */
    public function getRol($pid){
        try {
            if(empty($pid)) throw new Exception('invalid Id');
            $model=$this->repository->getById($pid);
            $dto=$this->mapper->reverse($model);

            return $dto;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Get roles all
     * @return array|null
     */
    public function getRoles(){
        try {
            $models=$this->repository->getRoles();
            $dtos=[];
            array_walk($models,function($model)use(&$dtos){
                $dto=$this->mapper->reverse($model);
                if(!empty($dto)) array_push($dtos,$dto);
            });

            return $dtos;

        } catch (\Throwable $th) {
            throw $th;
        }
    }
    
    public function AddAccionARol($pid,$accionPid){

    }
    public function AddAccionesARol($pid,array $accionesDto){

    }
}
