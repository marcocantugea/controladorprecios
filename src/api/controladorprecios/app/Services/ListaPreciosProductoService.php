<?php

namespace App\Services;

use App\Contractors\IMapper;
use App\Contractors\Repositories\IListaPreciosProductoRepository;
use App\Contractors\Repositories\IListaPreciosRepository;
use App\Contractors\Repositories\IProductosRepository;
use App\Contractors\Services\IListaPreciosProductoService;
use App\DTOs\ListaPreciosProductoDTO;
use Exception;

class ListaPreciosProductoService implements IListaPreciosProductoService
{

    private IListaPreciosProductoRepository $repository;
    private IMapper $mapper;
    private IListaPreciosRepository $listaPrecioRepository;
    private IProductosRepository $productoRepository;

    public function __construct(IListaPreciosProductoRepository $repository, IMapper $mapper, IListaPreciosRepository $listaPrecioRepository, IProductosRepository $prodctoRepository) {
        $this->repository = $repository;
        $this->mapper= $mapper;
        $this->listaPrecioRepository=$listaPrecioRepository;
        $this->productoRepository=$prodctoRepository;
    }

    /**
     * Add Lista Precio Producto
     * @param ListaPreciosProductoDTO $dto
     * @return string|null
     */
    public function addListaPrecioProducto($dto){
        try {
            if(empty($dto->precio) || empty($dto->productoPId) || empty($dto->listaPid)) throw new Exception('invalid product id or price');
            if($this->repository->existProductOnList($dto->productoPId,$dto->listaPid)) throw new Exception('product already added to the selected list');
            $lista= $this->listaPrecioRepository->getById($dto->listaPid);
            $producto= $this->productoRepository->getById($dto->productoPId)->first();
            $model = $this->mapper->map($dto);
            $model->listapreciosId= $lista->id;
            $model->productoId= $producto->id;
            return $this->repository->add($model);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * update lista precio producto
     * @param ListaPreciosProductoDTO $dto
     * @return void
     */
    public function updateListaPrecioProducto($dto){
        try {
            if(empty($dto->publicId)) throw new Exception('invalid product id');
            $model = $this->mapper->map($dto);
            $this->repository->update($model);

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Delete lista precio producto
     * @param string $pid
     * @return void
     */
    public function deleteListaPrecioProducto($pid){
        try {
            $this->repository->delete($pid);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Get Lista Precio Producto
     * @param string $pid
     * @return ListaPreciosProductoDTO
     */
    public function getListaPrecioProductoById($pid){
        return $this->mapper->reverse($this->repository->getById($pid));
    }

    public function getProductosPorListaPrecios($listaPId){
        try {
            $models= $this->repository->getProductosPorListaPrecios($listaPId);
            $dtos=[];
            foreach ($models as $model) {
                $dto= $this->mapper->reverse($model);
                if(empty($dto)) continue;
                array_push($dtos,$dto);
            }

            return $dtos;
        } catch (\Throwable $th) {
            throw $th;
        }
    } 

    public function addProductosAListaPrecios(array $dtos){
        try {
            $models=[];
            foreach ($dtos as $dto) {
                $lista= $this->listaPrecioRepository->getById($dto->listaPid);
                $producto= $this->productoRepository->getById($dto->productoPId)->first();
                $model = $this->mapper->map($dto);
                $model->listapreciosId= $lista->id;
                $model->productoId= $producto->id;
                array_push($models,$model);
            }

            $this->repository->addProductosAListaPrecios($models);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Get prices by lista and producto
     * @param string $listaPid
     * @param string $productoPid
     * @return array|null
     */
    public function getProductoPrecio($listaPid,$productoPid){
        try {
            $models=$this->repository->getProductoPrecio($listaPid,$productoPid);
            $dtos=[];
            foreach ($models as $model) {
                $dto=$this->mapper->reverse($model);
                array_push($dtos,$dto);
            }

            return $dtos;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Get producto precios
     * @param string $productoId;
     * @return array|null;
     */
    public function getProductoPrecios($productoId){
        try {
            $models= $this->repository->getProductoPrecios($productoId);
            $dtos=[];
            foreach ($models as $model) {
                $dto=$this->mapper->reverse($model);
                array_push($dtos,$dto);
            }

            return $dtos;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
