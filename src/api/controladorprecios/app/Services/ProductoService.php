<?php

namespace App\Services;

use App\Contractors\Data\IRepository;
use App\Contractors\Models\Producto;
use App\Contractors\IMapper;
use App\Contractors\Models\ProveedorProducto;
use App\Contractors\Services\IProductosService;
use App\Contractors\Repositories\IProductosRepository;
use App\Contractors\Repositories\IProveedorRepository;
use App\DTOs\AtributoDTO;
use App\DTOs\CategoriaDTO;
use App\DTOs\MarcaDTO;
use App\DTOs\ProductoAtributoDTO;
use App\DTOs\ProductoDTO;
use App\DTOs\ProveedorProductoDTO;
use App\DTOs\UnidadMedidaDTO;
use App\Mappers\ProductoMapper;
use Exception;
use Illuminate\Database\MySqlConnection;
use PHPUnit\Framework\Constraint\Operator;

class ProductoService implements IProductosService
{
    private IProductosRepository $productoRepository;
    private IProveedorRepository $proveedorRepository;
    private IMapper $productoMapper;
    private IMapper $categoriasMapper;
    private IMapper $proveedorProductoMapper;

    public function __construct(IProductosRepository $productRepository,
    IMapper $productoMapper,
    IMapper $categoriasMapper,
    IProveedorRepository $proveedorRepository,
    IMapper $proveedorProductoMapper
    ) {
        $this->productoRepository = $productRepository;
        $this->productoMapper=$productoMapper;
        $this->categoriasMapper=$categoriasMapper;
        $this->proveedorRepository=$proveedorRepository;
        $this->proveedorProductoMapper=$proveedorProductoMapper;
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
            if(count($producto)==0 )throw new Exception("producto not found");
            $productoDto=$this->productoMapper->reverse($producto[0]);
            $productoDto->categorias=$this->getCategorias($id);
            $productoDto->atributos=$this->getAtributos($id);
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

    public function updateProductoByProperty($id,array $propertyValue){
        
        $updateFields=[];
        
        //update main properties of product
        $updatableFields=[
            "nombre",
            "descripcion",
            "codigo",
            "sku",
            "upc",
            "ean"
        ];

        foreach ($propertyValue as $key => $value) {
            if(in_array($key,$updatableFields)) {
                $updateFields+=[$key=>$value];
            }
        }
        
        try {
            if(count($updateFields)>0) $this->productoRepository->updateProductoByProperty($id,$updateFields);
        } catch (\Throwable $th) {
            throw $th;
        }

        $categoriasDTO=[];
        //proiedades de categorias agrega
        if(array_key_exists('categorias',$propertyValue)){
            $categoriasDTO = array_map(function($item){
                return new CategoriaDTO($item['nombre'],publicId:$item['publicId']);
            },$propertyValue['categorias']);
        }       
        
        try {
            if(count($categoriasDTO)>0 ) $this->productoRepository->assignCategoryToProduct($id,$categoriasDTO);
        } catch (\Throwable $th) {
            throw $th;
        }

        //TODO: add update to other properties 
        if(array_key_exists('atributos',$propertyValue)){    
            $atributos = array_map(function($item) use ($id){
                    $valor = (!isset($item['valor'])) ? "" : $item['valor'];
                    $productoAtributoDto=new ProductoAtributoDTO($id,$item['atributoId'],$valor);
                    $unidadMedida=null;
                    if(isset($item['unidadMedida'])){
                            $productoAtributoDto->unidadMedida= new UnidadMedidaDTO($item['unidadMedida']['codigo'],"",publicId: $item['unidadMedida']['publicId']);
                    }
                    $marca=null;
                    if(isset($item['marca'])){
                        $productoAtributoDto->marca= new MarcaDTO($item['marca']['marca'],publicId:$item['marca']['publicId']);
                    }
                    return $productoAtributoDto;
                },$propertyValue['atributos']);
            try {
                if(count($atributos)>0) $this->productoRepository->assignAtributoToProduct($id,$atributos);
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        if(array_key_exists('proveedor',$propertyValue)){
            if(!isset($propertyValue['proveedor']['proveedorPublicId'])) throw new Exception("invalid proveedor id");
            $dto=new ProveedorProductoDTO($propertyValue['proveedor']['proveedorPublicId'],$id);
            try {
                $this->assignProveedor($dto);
            } catch (\Throwable $th) {
                throw $th;
            }
            
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
                $producto=$this->productoMapper->reverse($item);
                $producto->categorias=$this->getCategorias($producto->publicId);
                $producto->atributos =$this->getAtributos($producto->publicId);
                array_push($productosDTOFound,$producto);
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

    private function assignCategory($id, array $categoryDtos){
        try {
            $this->productoRepository->assignCategoryToProduct($id,$categoryDtos);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    private function getCategorias($id): array{

        $categorias=[];

        $getCatetorias= $this->productoRepository->getCategoriasOfProducto($id);

        foreach ($getCatetorias as $value) {
            $categorias[]=$this->categoriasMapper->map($value);
        }

        return $categorias;

    }

    private function getAtributos($id) :array {
        $atributos=[];
        $itemsFound=$this->productoRepository->getAtributosOfProducto($id)->map(function($item) use ($id){
            $atributoDTO= new ProductoAtributoDTO($id,$item->atributoPublicId,$item->valor);
            $atributoDTO->atributo=$item->atributo;
            $atributoDTO->unidadMedida=new UnidadMedidaDTO($item->codigo,$item->unidadMedida,$item->unidadesmedidasPublicId);
            $atributoDTO->marca= (!empty($item->marcaPublicId)) ? new MarcaDTO($item->marca,$item->marcaPublicId,$item->marcaActivo) : null;
            return $atributoDTO;
        })->toArray();
        return $itemsFound;
    }

    public function assignProveedor(ProveedorProductoDTO $proveedorProducto){
        try {
            $proveedorProducto->productoId= $this->productoRepository->getById($proveedorProducto->productoPublicId)->first()->id;
            $proveedorProducto->proveedorId= $this->proveedorRepository->getById($proveedorProducto->proveedorPublicId)->id;
            if(empty($proveedorProducto->productoId) || empty($proveedorProducto->proveedorId)) throw new Exception("invalid id of producto or proveedor");
            $model=$this->proveedorProductoMapper->map($proveedorProducto);
            $this->proveedorRepository->addProveedorProducto($model);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
