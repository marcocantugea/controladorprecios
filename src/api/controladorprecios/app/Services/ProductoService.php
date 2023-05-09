<?php

namespace App\Services;

use App\Contractors\Data\IRepository;
use App\Contractors\Models\Producto;
use App\Contractors\IMapper;
use App\Contractors\Services\IProductosService;
use App\Contractors\Repositories\IProductosRepository;
use App\DTOs\ProductoDTO;
use App\Mappers\ProductoMapper;
use Illuminate\Database\MySqlConnection;
use PHPUnit\Framework\Constraint\Operator;

class ProductoService implements IProductosService
{
    private IProductosRepository $productoRepository;
    private IMapper $productoMapper;

    public function __construct(IProductosRepository $productRepository,IMapper $productoMapper) {
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

    public function getProductos(array $searchParams,int $limit=500,int $offset=0){
        try {
            
            $fiedlsLikeOperator=[
                "nombre",
                "descripcion",
                "codigo",
                "sku",
                "upc",
                "ean"
            ];
            $productoModel=get_class_vars(Producto::class);
            $filterSearhParams=[];
            foreach ($searchParams as $key => [$value,$operator]) {
                if(!in_array($key,array_keys($productoModel))) continue;
                if(in_array($key,$fiedlsLikeOperator)) $operator='like';
                $filterSearhParams+=[$key=>[$value,$operator]];
            }

            $productosFound=$this->productoRepository->getProductos($filterSearhParams,$limit,$offset);
            $productosDTOFound=[];

            foreach ($productosFound as $item) {
                array_push($productosDTOFound,$this->productoMapper->reverse($item));
            }

            $response=[
                'offset'=>$offset,
                'limit'=>$limit,
                'totalRecordsFound'=>count($productosDTOFound),
                'data'=>$productosDTOFound
            ];

            return $response;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
