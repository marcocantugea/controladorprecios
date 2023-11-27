<?php

namespace App\Services;

use App\Contractors\IMapper;
use App\Contractors\Repositories\IAccionesRepository;
use App\Contractors\Services\IAccionesService;
use Exception;

class AccionesService implements IAccionesService
{
    private IAccionesRepository $repository;
    private IMapper $mapper;

    public function __construct(IAccionesRepository $repository, IMapper $mapper) {
        $this->repository=$repository;
        $this->mapper=$mapper;
    }

    public function getAccionById($pid)
    {
        try {
            if(empty($pid)) throw new Exception('invalid id');
            $model= $this->repository->getAccionById($pid);
            $dto=$this->mapper->reverse($model);
            return $dto;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getAcciones()
    {
        try {
            $models= $this->repository->getAcciones();

            $dtos=[];
            array_walk($models,function($model) use (&$dtos){
                $dto=$this->mapper->reverse($model);
                if(!empty($dto)) array_push($dtos,$dto);
            });
            
            return $dtos;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
