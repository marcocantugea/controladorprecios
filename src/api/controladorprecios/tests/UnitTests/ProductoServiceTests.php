<?php

namespace Tests\UnitTests;

use App\Contractors\IMapper;
use App\Contractors\Repositories\IProductosRepository;
use App\Mappers\ProductoMapper;
use App\Contractors\Models\Producto;
use App\DTOs\CategoriaDTO;
use App\DTOs\ProductoDTO;
use App\Mappers\CategoriaMapper;
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
    protected IMapper $categoriaMapperMock;
    
    protected function setUp(): void
    {
       parent::setUp();
       $this->db=$this->app->make('db')->connection();
       
       $this->productosRepositoryMock=$this->getMockBuilder(ProductosRepository::class)
                                                ->setConstructorArgs(array($this->db))
                                                ->onlyMethods(['add','getById','getProductos','updateProductoByProperty','getCategoriasOfProducto'])
                                                ->getMock();

       $this->productoMapperMock=$this->getMockBuilder(ProductoMapper::class)
                                        ->onlyMethods(['map','reverse'])
                                        ->getMock();

        $this->categoriaMapperMock= $this->getMockBuilder(CategoriaMapper::class)
                                            ->onlyMethods(['map','reverse'])
                                            ->getMock();

       $this->productoService= new ProductoService($this->productosRepositoryMock,$this->productoMapperMock,$this->categoriaMapperMock);
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
        $this->productosRepositoryMock->method('getCategoriasOfProducto')->willReturn([]);

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

    public function test_ShouldGetProductos_Success_NoFilters(){
        
        $productosMocked=$this->getMockProducts();
        $this->productosRepositoryMock->method('getProductos')->willReturn($productosMocked);
        $this->productosRepositoryMock->method('getCategoriasOfProducto')->willReturn([]);
        $this->productoMapperMock->method('reverse')->willReturn($this->returnCallback(function($item){
            $productos=array_filter($this->getMockProducts(),function($producto) use ($item){
                return $producto->nombre==$item->nombre;
            });
            $producto=current($productos);
            return new ProductoDTO(
                $producto->publicId= uniqid(),
                $producto->nombre,
                $producto->descripcion,
                $producto->codigo,
                $producto->sku,
                $producto->sku,
                $producto->ean
            );
        }))
        ;

        $productosFound=$this->productoService->getProductos([]);

        $this->assertEquals(count($this->getMockProducts()),$productosFound['totalRecordsFound']);
        $this->assertEquals(count($this->getMockProducts()),count($productosFound['data']));
        

    }

    public function test_ShouldGetProductos_Success_OneFilter(){
        
        $productoToReturn=array_filter($this->getMockProducts(), function($items){
            return $items->codigo=='codigo1';
        });

        $returnItems=json_decode(json_encode($productoToReturn));

        $this->productosRepositoryMock->method('getProductos')->willReturn($returnItems);
        $this->productosRepositoryMock->method('getCategoriasOfProducto')->willReturn([]);

        $productoDTOReturn=new ProductoDTO(
            $productoToReturn[0]->nombre,
            $productoToReturn[0]->descripcion,
            $productoToReturn[0]->codigo,
            $productoToReturn[0]->sku,
            $productoToReturn[0]->upc,
            $productoToReturn[0]->ean
        );
        $this->productoMapperMock->method('reverse')->willReturn($productoDTOReturn);


        $filter=[
            'codigo'=>['codigo1',null]
        ];

        $productosFound=$this->productoService->getProductos($filter);

        $this->assertEquals(1,$productosFound['totalRecordsFound']);
        $this->assertEquals(1,count($productosFound['data']));
        $this->assertEquals('codigo1',$productosFound['data'][0]->codigo);
    }

    public function test_ShouldGetProductos_Success_SomeFilter(){

        $productoToReturn=array_filter($this->getMockProducts(), function($items){
            return $items->codigo=='codigo1' || $items->sku=='sku3';
        });

        $returnItems=json_decode(json_encode($productoToReturn));

        $this->productosRepositoryMock->method('getProductos')->willReturn($returnItems);
        $this->productosRepositoryMock->method('getCategoriasOfProducto')->willReturn([]);

        $productoDTOReturn=new ProductoDTO(
            $productoToReturn[0]->nombre,
            $productoToReturn[0]->descripcion,
            $productoToReturn[0]->codigo,
            $productoToReturn[0]->sku,
            $productoToReturn[0]->upc,
            $productoToReturn[0]->ean
        );

        $this->productoMapperMock->method('reverse')->willReturn($productoDTOReturn);

        $filter=[
            'codigo'=>['codigo1',null],
            'sku'=>['sku3',null]
        ];

        $productosFound=$this->productoService->getProductos($filter);

        $this->assertEquals(2,$productosFound['totalRecordsFound']);
        $this->assertEquals(2,count($productosFound['data']));
    }

    public function test_ShouldGetProductos_Success_WithOffset(){
        
        $productoToReturn=array_filter($this->getMockProducts(), function($items){
            return $items->codigo=='codigo1' || $items->sku=='sku3';
        });

        $returnItems=json_decode(json_encode($productoToReturn));

        $this->productosRepositoryMock->method('getProductos')->willReturn($returnItems);
        $this->productosRepositoryMock->method('getCategoriasOfProducto')->willReturn([]);

        $productoDTOReturn=new ProductoDTO(
            $productoToReturn[0]->nombre,
            $productoToReturn[0]->descripcion,
            $productoToReturn[0]->codigo,
            $productoToReturn[0]->sku,
            $productoToReturn[0]->upc,
            $productoToReturn[0]->ean
        );

        $this->productoMapperMock->method('reverse')->willReturn($productoDTOReturn);

        $filter=[
            'codigo'=>['codigo1',null],
            'sku'=>['sku3',null]
        ];

        $productosFound=$this->productoService->getProductos($filter,offset:1);

        $this->assertEquals(2,$productosFound['totalRecordsFound']);
        $this->assertEquals(2,count($productosFound['data']));
    }

    public function test_ShouldGetProductos_Success_WithLimit(){

        $productoToReturn=array_filter($this->getMockProducts(), function($items){
            return $items->codigo=='codigo1' || $items->sku=='sku3';
        });

        $returnItems=json_decode(json_encode($productoToReturn));

        $this->productosRepositoryMock->method('getProductos')->willReturn($returnItems);
        $this->productosRepositoryMock->method('getCategoriasOfProducto')->willReturn([]);

        $productoDTOReturn=new ProductoDTO(
            $productoToReturn[0]->nombre,
            $productoToReturn[0]->descripcion,
            $productoToReturn[0]->codigo,
            $productoToReturn[0]->sku,
            $productoToReturn[0]->upc,
            $productoToReturn[0]->ean
        );

        $this->productoMapperMock->method('reverse')->willReturn($productoDTOReturn);

        $filter=[
            'codigo'=>['codigo1',null],
            'sku'=>['sku3',null]
        ];

        $productosFound=$this->productoService->getProductos($filter,limit:1);

        $this->assertEquals(2,$productosFound['totalRecordsFound']);
        $this->assertEquals(2,count($productosFound['data']));
    }

    public function test_ShouldUpdateProductoByProperties(){

        $publicid=uniqid();
        $propertyValues=[
            'nombre'=>'newnombre',
            'codigo'=>'codigo'
        ];

        $this->productosRepositoryMock
                    ->expects($this->once())
                    ->method('updateProductoByProperty')
                    ->with($this->equalTo($publicid),$this->equalTo($propertyValues));

        $this->productoService->updateProductoByProperty($publicid,$propertyValues);
    }

    private function getMockProducts(){
        
        $model1= new Producto(); 
        $model1->nombre="productoPrueba1";
        $model1->descripcion="descripcion prueba1";
        $model1->codigo="codigo1";
        $model1->sku="sku1";
        $model1->upc="upc1";
        $model1->ean="ean1";

        $model2= new Producto(); 
        $model2->nombre="productoPrueba2";
        $model2->descripcion="descripcion prueba2";
        $model2->codigo="codigo2";
        $model2->sku="sku2";
        $model2->upc="upc2";
        $model2->ean="ean2";

        $model3= new Producto(); 
        $model3->nombre="productoPrueba3";
        $model3->descripcion="descripcion prueba3";
        $model3->codigo="codigo3";
        $model3->sku="sku3";
        $model3->upc="upc3";
        $model3->ean="ean3";

        $model4= new Producto(); 
        $model4->nombre="productoPrueba4";
        $model4->descripcion="descripcion prueba4";
        $model4->codigo="codigo4";
        $model4->sku="sku4";
        $model4->upc="upc4";
        $model4->ean="ean4";

        $model5= new Producto(); 
        $model5->nombre="productoPrueba5";
        $model5->descripcion="descripcion prueba5";
        $model5->codigo="codigo5";
        $model5->sku="sku5";
        $model5->upc="upc5";
        $model5->ean="ean5";

        return json_decode(json_encode([$model1,$model2,$model3,$model4,$model5]));
    }
}