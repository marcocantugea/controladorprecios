<?php

namespace App\Services;

use App\Contractors\IMapper;
use App\Contractors\Models\Costo;
use App\Contractors\Models\Producto;
use App\Contractors\Models\Proveedor;
use App\Contractors\Repositories\ICostosRepository;
use App\Contractors\Repositories\IProductosRepository;
use App\Contractors\Repositories\IProveedorRepository;
use App\Contractors\Services\ICostosService;
use App\DTOs\CostoDTO;
use DateTime;
use Exception;

class CostosService implements ICostosService
{
    private ICostosRepository $repository;
    private IMapper $mapper;
    private IProveedorRepository $proveedorRepository;
    private IProductosRepository $productoRepository;

    public function __construct(ICostosRepository $repository, IMapper $costoMapper,IProveedorRepository $proveedorRepository, IProductosRepository $productoRepository) {
        $this->repository= $repository;
        $this->mapper=$costoMapper;
        $this->proveedorRepository=$proveedorRepository;
        $this->productoRepository=$productoRepository;
    }

    public function addCosto(CostoDTO $costo){
        
        try {
            if(empty($costo->proveedorPublicId) || empty($costo->productoPublicId)) throw new Exception("invalid ids");
            $costo->proveedorId=$this->proveedorRepository->getById($costo->proveedorPublicId)->id;
            $costo->productoId=$this->productoRepository->getById($costo->productoPublicId)->first()->id;
            if(empty($costo->productoId) || empty($costo->proveedorId)) throw new Exception("invalid ids");
            if($this->repository->existProveedorAndProduct($costo->proveedorId,$costo->productoId)) throw new Exception("producto and proveedor already exist");
            $model=$this->mapper->map($costo);
            $this->repository->add($model);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function addCostos(array $costos){

        try {
            array_walk($costos,function($item){
                if(!$item instanceof CostoDTO) throw new Exception("invalid instance of dto");
                $this->addCosto($item);
            });
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function updateCosto(CostoDTO $costo){
        try {
            $costo->proveedorId=$this->proveedorRepository->getById($costo->proveedorPublicId)->id;
            $costo->productoId=$this->productoRepository->getById($costo->productoPublicId)->first()->id;
            if(empty($costo->productoId) || empty($costo->proveedorId)) throw new Exception("invalid ids");
            $model= $this->mapper->map($costo);
            $this->repository->update($model);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function updateCostos(array $costos){
        try {
            array_walk($costos,function($item){
                if(!$item instanceof CostoDTO) throw new Exception("invalid instance of dto");
                $this->updateCosto($item);
            }); 
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function deleteCosto($id){
        try {
            if(empty($id)) throw new Exception("invalid id");
            $this->repository->delete($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getCosto($id){
        try {
            if(empty($id)) throw new Exception("invalid id");
            $dto=$this->mapper->reverse($this->repository->getById($id));
            $dto->proveedorId=null;
            $dto->productoId=null;
            return $dto;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getCostosByProveedor($proveedorId){
        try {
            return $this->repository->getCostosByProveedor($proveedorId)->map(function($item){
                $dto= new CostoDTO($item->proveedorPublicId,
                                    $item->productoPublicId,
                                    $item->costo,$item->codigo,
                                    $item->nombreCorto,
                                    $item->nombreProducto,
                                    $item->expira_en,
                                    new DateTime($item->created_at),
                                    $item->fecha_eliminado
                                );
                $dto->publicId=$item->publicId;
                return $dto;
            });
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
