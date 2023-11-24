<?php

namespace App\Services;

use App\Contractors\IMapper;
use App\Contractors\Repositories\ICanalVentaListaPrecioRepository;
use App\Contractors\Services\ICanalVentaListaPrecioService;
use App\Contractors\Services\IListaPreciosService;
use App\Contractors\Services\IProductoService;
use App\DTOs\CanalVentaListaPrecioDTO;
use App\DTOs\ListaPreciosDetalleDTO;
use App\DTOs\ListaPreciosDTO;
use App\Helpers\DateTimeSetter;
use App\Mappers\CanalesVentaMapper;
use DateTime;
use Exception;

class CanalVentaListaPreciosService implements ICanalVentaListaPrecioService
{
    private ICanalVentaListaPrecioRepository $repository;
    private IMapper $mapper;
    private IMapper $canalVentaMapper;
    private IListaPreciosService $listaPreciosService;
    private IProductoService $productoService;

    public function __construct(ICanalVentaListaPrecioRepository $repository,IMapper $mapper,CanalesVentaMapper $canalVentaMapper,IListaPreciosService $listaPreciosService,IProductoService $productoService) {
        $this->repository = $repository;
        $this->mapper=$mapper;
        $this->canalVentaMapper=$canalVentaMapper;
        $this->listaPreciosService=$listaPreciosService;
        $this->productoService=$productoService;
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

    function getListaPrecioPorCanal($pid,$listaPid){
        try {
            if(empty($pid) || empty($listaPid)) throw new Exception('invalid id or lista id');
            $listas= $this->repository->getListasPrecioPorCanalVenta($pid);
            $dtos=[];
            foreach ($listas as $lista) {
                if($lista->listaPid!=$listaPid) continue;
                $response=$this->listaPreciosService->getListaPreciosHeader($listaPid);
                $listaPrecioInicio=DateTimeSetter::setDateTime($response->fecha_inicia);
                $listaPrecioFin=DateTimeSetter::setDateTime($response->fecha_expira);
                $todayDate=new DateTime();
                if($todayDate<$listaPrecioInicio && $todayDate>$listaPrecioFin) continue;
                $listaHeader= new ListaPreciosDTO();
                $listaHeader->publicId=$response->publicId;
                $listaHeader->descripcion=$response->descripcion;
                $listaHeader->codigo=$response->codigo;
                $listaHeader->activo=$response->activo;
                $listaHeader->fechaInicio=DateTimeSetter::setDateTime($response->fecha_inicia);
                $listaHeader->fechaExpira=DateTimeSetter::setDateTime($response->fecha_expira);

                //get detail prices
                $productos=$this->listaPreciosService->getListaPreciosProductos($listaPid);
                $listaProductos=[];
                array_walk($productos,function($item) use (&$listaProductos){
                    $producto=new ListaPreciosDetalleDTO();
                    $producto->publicId=$item->publicId;
                    $producto->productoId=$item->productoPId;
                    $producto->precio=$item->precio;
                    $producto->activo=$item->activo;
                    $producto->producto=$this->productoService->getProductoSimple($item->productoPId);

                    array_push($listaProductos,$producto);

                });
                $listaHeader->precios=$listaProductos;
                array_push($dtos,$listaHeader);
            }

            return $dtos;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
