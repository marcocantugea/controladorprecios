<?php 

namespace App\Services;

use App\Contractors\IMapper;
use App\Contractors\Repositories\IModuloRepository;
use App\Contractors\Services\IModuloService;
use App\DTOs\ModuloDTO;
use App\DTOs\RolModuloDTO;

class ModuloService implements IModuloService
{
    private IModuloRepository $repository;
    private IMapper $mapper;
    private IMapper $rolModuloMapper;

    public function __construct(IModuloRepository $repository, IMapper $mapper,IMapper $rolModuloMapper) {
        $this->repository=$repository;
        $this->mapper =$mapper;
        $this->rolModuloMapper=$rolModuloMapper;
    }
    
    public function addModulo(ModuloDTO $dto){
        try {
            $model=$this->mapper->map($dto);
            $publicId=$this->repository->add($model);
            return $publicId;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function updateModulo(ModuloDTO $dto){
        try {
            $model=$this->mapper->map($dto);
            $this->repository->update($model);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function deleteModulo(string $pid){
        try {
            $this->repository->delete($pid);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getModuloById(string $pid){
        try {
            $model=$this->repository->getById($pid);
            $dto=$this->mapper->reverse($model);
            return $dto;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getModulosByRol(string $rolId){
        try {
            $models=$this->repository->getModulosByRol($rolId);
            $dtos=[];
            array_walk($models,function($model) use (&$dtos){
                $dto=$this->mapper->reverse($model);
                if(!empty($model)) array_push($dtos,$dto);
            });

            return $dtos;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getModulos(){
        try {
            $models=$this->repository->getModulos();
            $dtos=[];
            array_walk($models,function($model) use (&$dtos){
                $dto=$this->mapper->reverse($model);
                if(!empty($model)) array_push($dtos,$dto);
            });

            return $dtos;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function addModuloRol(RolModuloDTO $dto)
    {
        try {
            $model=$this->rolModuloMapper->map($dto);
            $publicId=$this->repository->addModuloRol($model);
            return $publicId;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function deleteModuloRol(string $pid)
    {
        try {
            $this->repository->deleteModuloRol($pid);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getRolModulosIds(string $rolPid)
    {
        try {
            $models=$this->repository->getRolModulosIds($rolPid);
            $dtos=[];
            array_walk($models,function($model) use (&$dtos){
                $dto=$this->rolModuloMapper->reverse($model);
                if(!empty($dto))    array_push($dtos,$dto);
            });

            return $dtos;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}
