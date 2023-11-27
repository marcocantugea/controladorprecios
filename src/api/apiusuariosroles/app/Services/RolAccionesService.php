<?php

namespace App\Services;

use App\Contractors\IMapper;
use App\Contractors\Repositories\IRolAccionRepository;
use App\Contractors\Services\IAccionesService;
use App\Contractors\Services\IRolAccionService;
use App\DTOs\RolAccionDTO;
use Exception;
use Illuminate\Support\Arr;

class RolAccionesService implements IRolAccionService
{

    private IRolAccionRepository $repository;
    private IMapper $mapper;
    private IAccionesService $accionService;

    public function __construct(IRolAccionRepository $repository, IMapper $mapper,IAccionesService $accionService) {
        $this->repository=$repository;
        $this->mapper=$mapper;
        $this->accionService=$accionService;
    }

    public function addRolAccion(RolAccionDTO $dto){
        try {
            $model=$this->mapper->map($dto);
            $publicId=$this->repository->add($model);
            return $publicId;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function deleteRolAccion(string $pid){
        try {
            $this->repository->delete($pid);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getRolAccion(string $pid){
        try {
            $model=$this->repository->getById($pid);
            $dto=$this->mapper->reverse($model);
            return $dto;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getAccionesPorRol(string $rolPid){
        try {
            $models=$this->repository->getAccionesPorRol($rolPid);
            $dtos=[];
            array_walk($models,function($model) use (&$dtos){
                $dto=$this->mapper->reverse($model);
                $dto->accion= $this->accionService->getAccionById($dto->accionPid);
                if(!empty($dto)) array_push($dtos,$dto);
            });

            return $dtos;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getAccionesRoles(){
        try {
            $models=$this->repository->getAccionesRoles();
            $dtos=[];
            array_walk($models,function($model) use (&$dtos){
                $dto=$this->mapper->reverse($model);
                $dto->accion= $this->accionService->getAccionById($dto->accionPid);
                if(!empty($dto)) array_push($dtos,$dto);
            });

            return $dtos;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function addAccionesARol(array $dtos)
    {
        try {
            $models=[];
            array_walk($dtos,function($dto) use (&$models){
                if(!$dto instanceof RolAccionDTO) throw new Exception('invalid dto');
                $model=$this->mapper->map($dto);
                if(!empty($model)) array_push($models,$model);
            });

            $publicIds=$this->repository->addAccionesARole($models);
            return $publicIds;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
