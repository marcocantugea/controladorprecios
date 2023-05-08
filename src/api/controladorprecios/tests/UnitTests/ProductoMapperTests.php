<?php

namespace Tests\UnitTests;

use App\Mappers\ProductoMapper;
use App\Contractors\Models\Producto;
use App\DTOs\ProductoDTO;
use Tests\TestCase;

class ProductoMapperTests extends TestCase
{
    
    // /** @var Productosrepository */
    protected ProductoMapper $productoMapper;
    
    protected function setUp(): void
    {
       parent::setUp();
       $this->productoMapper = new ProductoMapper();
       
       
    }

    public function test_ShouldMapProductoModel(){

        $model= new Producto(); 
        $model->publicId=uniqid();
        $model->nombre="productoPrueba";
        $model->descripcion="descripcion prueba";
        $model->codigo="codigo";
        $model->sku="sku";
        $model->upc="upc";
        $model->ean="ean";

        $json= json_encode($model);

        $jsonParsed=json_decode($json);

        $productModel= $this->productoMapper->map($jsonParsed);
        
        $this->assertInstanceOf(Producto::class,$productModel);
        $this->assertEquals($model->publicId,$productModel->publicId);
        $this->assertEquals($model->nombre,$productModel->nombre);
        $this->assertEquals($model->descripcion,$productModel->descripcion);
        $this->assertEquals($model->codigo,$productModel->codigo);
        $this->assertEquals($model->sku,$productModel->sku);
        $this->assertEquals($model->upc,$productModel->upc);
        $this->assertEquals($model->ean,$productModel->ean);

    }


    public function test_ShouldMapProductoDTO(){

        $model= new Producto(); 
        $model->publicId=uniqid();
        $model->nombre="productoPrueba";
        $model->descripcion="descripcion prueba";
        $model->codigo="codigo";
        $model->sku="sku";
        $model->upc="upc";
        $model->ean="ean";

        $json= json_encode($model);

        $jsonParsed=json_decode($json);

        $productModel= $this->productoMapper->reverse($jsonParsed);
        
        $this->assertInstanceOf(ProductoDTO::class,$productModel);
        $this->assertEquals($model->nombre,$productModel->nombre);
        $this->assertEquals($model->descripcion,$productModel->descripcion);
        $this->assertEquals($model->codigo,$productModel->codigo);
        $this->assertEquals($model->sku,$productModel->sku);
        $this->assertEquals($model->upc,$productModel->upc);
        $this->assertEquals($model->ean,$productModel->ean);

    }

}
