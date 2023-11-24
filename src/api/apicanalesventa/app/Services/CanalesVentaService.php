<?php

namespace App\Services;

use App\Contractors\IMapper;
use App\Contractors\Repositories\ICanalesVentaRepository;
use App\Contractors\Services\ICanalesVentaService;
use App\DTOs\CanalVentaDTO;
use Exception;
use Illuminate\Http\Response;

class CanalesVentaService implements ICanalesVentaService
{

    private ICanalesVentaRepository $repository;
    private IMapper $mapper;

    public function __construct(ICanalesVentaRepository $repository, IMapper $mapper) {
        $this->repository=$repository;
        $this->mapper=$mapper;
    }

    /**
     * Add new Canal de Venta
     * @param CanalVentaDTO $dto
     * @return string
     */
    public function addCanalVenta($dto){
        try {
            if(empty($dto->nombre)) throw new Exception('invalid nombre de canal de venta');
            $model= $this->mapper->map($dto);
            $publicId=$this->repository->add($model);
            return $publicId;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Update Canal Venta
     * @param CanalVentaDTO $dto
     * @return void
     */
    public function updateCanalVenta($dto)
    {
        try {
            if(empty($dto->nombre)) throw new Exception('invalid nombre de canal de venta');
            $model= $this->mapper->map($dto);
            $this->repository->update($model);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Get Canal by public id
     * @param string $pid
     * @return CanalVentaDTO 
     */
    public function getCanalVenta($pid){
        try {
            $model=$this->repository->getById($pid);
            $dto= $this->mapper->reverse($model);
            return $dto;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function deleteCanalVenta($pid)
    {
        try {
            $this->repository->delete($pid);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getCanalesVenta()
    {
        try {
            $models= $this->repository->getCanalesVenta();
            $dtos=[];
            array_walk($models,function($item) use (&$dtos){
                $dto=$this->mapper->reverse($item);
                array_push($dtos,$dto);
            });

            return $dtos;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
