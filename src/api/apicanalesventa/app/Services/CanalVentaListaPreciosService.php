<?php

namespace App\Services;

use App\Contractors\IMapper;
use App\Contractors\Repositories\ICanalVentaListaPrecioRepository;
use App\Contractors\Services\ICanalVentaListaPrecioService;
use App\DTOs\CanalVentaListaPrecioDTO;
use App\Mappers\CanalesVentaMapper;
use Exception;

class CanalVentaListaPreciosService implements ICanalVentaListaPrecioService
{
    private ICanalVentaListaPrecioRepository $repository;
    private IMapper $mapper;
    private IMapper $canalVentaMapper;

    public function __construct(ICanalVentaListaPrecioRepository $repository,IMapper $mapper,CanalesVentaMapper $canalVentaMapper) {
        $this->repository = $repository;
        $this->mapper=$mapper;
        $this->canalVentaMapper=$canalVentaMapper;
    }

    /**
     * add canal venta lista precio
     * @param CanalVentaListaPrecioDTO $dto
     * @return string|null 
     */
    public function addCanalVentaListaPrecio($dto)
    {
        try {
            if(empty($dto->listaPid) || empty($dto->canalventaPid)) throw new Exception('invalid lista and canal');
            $model=$this->mapper->map($dto);
            $publicId=$this->repository->add($model);
            return $publicId;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * remove canal venta lista precio
     * @param string $pid
     * @return void
     */
    public function deleteCanalVentaListaPrecio($pid)
    {
        try {
            if(empty($pid)) throw new Exception('invalid id');
            $this->repository->delete($pid);
        } catch (\Throwable $th) {
            throw $th;
        }
        
    }

    /**
     * Get lista dfe precios por canal
     * @param string $pid
     * @return array|null
     */
    public function getListaPreciosPorCanal($pid)
    {
        try {
            $models= $this->repository->getListasPrecioPorCanalVenta($pid);
            $dtos=[];
            array_walk($models,function($model) use (&$dtos){
                $dto= $this->mapper->reverse($model);
                array_push($dtos,$dto);
            });

            return $dtos;
        } catch (\Throwable $th) {
            throw $th;
        }   
    }

    public function getCanalesPorListaPrecios($listaPid)
    {
        try {
            $models=$this->repository->getCanalVentaPorListaPrecio($listaPid);
            $dtos=[];
            array_walk($models,function($model) use (&$dtos){
                $dto=$this->canalVentaMapper->reverse($model);
                array_push($dtos,$dto);
            });

            return $dtos;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
