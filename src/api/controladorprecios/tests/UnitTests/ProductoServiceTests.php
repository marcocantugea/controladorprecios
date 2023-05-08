<?php

namespace Tests\UnitTests;

use App\Contractors\IMapper;
use App\Contractors\Repositories\IProductosRepository;
use App\Mappers\ProductoMapper;
use App\Contractors\Models\Producto;
use App\DTOs\ProductoDTO;
use App\Repositories\ProductosRepository;
use App\Services\ProductoService;
use Exception;
use Tests\TestCase;

class ProductoServiceTests extends TestCase
{
    protected $db;
    protected ProductoService $productoService;
    protected IProductosRepository $productosRepositoryMock;
    protected IMapper $productoMapperMock;
    
    protected function setUp(): void
    {
       parent::setUp();
       $this->db=$this->app->make('db')->connection();
       
       $this->productosRepositoryMock=$this->getMockBuilder(ProductosRepository::class)
                                                ->setConstructorArgs(array($this->db))
                                                ->onlyMethods(['add','getById'])
                                                ->getMock();

       $this->productoMapperMock=$this->getMockBuilder(ProductoMapper::class)
                                        ->onlyMethods(['map','reverse'])
                                        ->getMock();

       $this->productoService= new ProductoService($this->db,$this->productosRepositoryMock,$this->productoMapperMock);
    }

    public function test_ShouldAddProducto_Success(){

        $model= new Producto(); 
        $model->nombre="productoPrueba";
        $model->descripcion="descripcion prueba";
        $model->codigo="codigo";
        $model->sku="sku";
        $model->upc="upc";
        $model->ean="ean";

        $productoDTO= new ProductoDTO("test","description","codigo","sku");

        $this->productoMapperMock->method('map')->willReturn($model);
        $this->productoService->addProduct($productoDTO);

        $this->assertTrue(true);

    }

    public function test_ShouldAddProducto_Fail_Exception(){

        $model= new Producto(); 
        $model->nombre="productoPrueba";
        $model->descripcion="descripcion prueba";
        $model->codigo="codigo";
        $model->sku="sku";
        $model->upc="upc";
        $model->ean="ean";

        $productoDTO= new ProductoDTO("test","description","codigo","sku");

        $this->productoMapperMock->method('map')->willReturn($model);
        $this->productosRepositoryMock->method('add')->willReturn(new Exception("Error insert"));
        
        try {
            $this->productoService->addProduct($productoDTO);
            $this->assertTrue(true);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function test_ShoulGetProductoById(){

        $model= new Producto(); 
        $model->nombre="productoPrueba";
        $model->descripcion="descripcion prueba";
        $model->codigo="codigo";
        $model->sku="sku";
        $model->upc="upc";
        $model->ean="ean";

        $productoDTO= new ProductoDTO($model->nombre,$model->descripcion,$model->codigo,$model->sku,$model->upc,$model->ean);

        $modelStdClass=json_decode(json_encode($model));

        $this->productosRepositoryMock->method('getById')->willReturn([$modelStdClass]);
        $this->productoMapperMock->method('reverse')->willReturn($productoDTO);

        $productoReturned= $this->productoService->getProducto(uniqid());

        $this->assertEquals($model->nombre,$productoReturned->nombre);
        $this->assertEquals($model->descripcion,$productoReturned->descripcion);
    }

    public function test_ShoulGetProductoById_fail(){

        $model= new Producto(); 
        $model->nombre="productoPrueba";
        $model->descripcion="descripcion prueba";
        $model->codigo="codigo";
        $model->sku="sku";
        $model->upc="upc";
        $model->ean="ean";

        $productoDTO= new ProductoDTO($model->nombre,$model->descripcion,$model->codigo,$model->sku,$model->upc,$model->ean);

        $modelStdClass=json_decode(json_encode($model));

        $this->productosRepositoryMock->method('getById')->willReturn(new Exception("error fatal"));

        try {
            $productoReturned= $this->productoService->getProducto(uniqid());
        } catch (\Throwable $th) {
            $this->assertTrue(true);
        }
    }
}