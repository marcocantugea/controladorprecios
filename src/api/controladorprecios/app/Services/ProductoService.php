<?php

namespace App\Services;

use App\Contractors\Data\IRepository;
use App\Contractors\IMapper;
use App\Contractors\Services\IProductosService;
use App\Contractors\Repositories\IProductosRepository;
use App\DTOs\ProductoDTO;
use App\Mappers\ProductoMapper;
use Illuminate\Database\MySqlConnection;

class ProductoService implements IProductosService
{
    private IProductosRepository $productoRepository;
    private IMapper $productoMapper;

    public function __construct(MySqlConnection $db,IProductosRepository $productRepository,IMapper $productoMapper) {
        $this->productoRepository = $productRepository;
        $this->productoMapper=$productoMapper;
    }

    public function addProduct(ProductoDTO $producto)
    {
        try {
            $productoModel = $this->productoMapper->map($producto);
            $this->productoRepository->add($productoModel);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getProducto($id):ProductoDTO{
        try {
            $producto=$this->productoRepository->getById($id);
            $productoDto=$this->productoMapper->reverse($producto[0]);
            return $productoDto;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function updateProducto(ProductoDTO $producto){
        try {
            $productoModel = $this->productoMapper->map($producto);
            $this->productoRepository->update($productoModel);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function deleteProducto($id){
        try {
            $this->productoRepository->delete($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
