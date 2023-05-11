<?php

namespace Tests\UnitTests;

use App\Contractors\Models\Categoria;
use App\Contractors\Models\Producto;
use App\DTOs\CategoriaDTO;
use App\Mappers\CategoriaMapper;
use Tests\TestCase;

class CategoriasMapperTests extends TestCase
{
    
    // /** @var CategoriaMapper */
    protected CategoriaMapper $categoriaMapper;
    
    protected function setUp(): void
    {
       parent::setUp();
       $this->categoriaMapper = new CategoriaMapper();
       
       
    }

    public function test_ShouldMapCategoryModel(){

        $model= new Categoria(); 
        $model->publicId=uniqid();
        $model->nombre="productoPrueba";

        $json= json_encode($model);

        $jsonParsed=json_decode($json);

        $categoriaModel= $this->categoriaMapper->map($jsonParsed);
        
        $this->assertInstanceOf(Categoria::class,$categoriaModel);
        $this->assertEquals($model->publicId,$categoriaModel->publicId);
        $this->assertEquals($model->nombre,$categoriaModel->nombre);
    }

    public function test_ShouldMapCategoryModel_DTO(){

        $model= new CategoriaDTO("productoPrueba",true); 
        
        $categoriaModel= $this->categoriaMapper->map($model);
        
        $this->assertInstanceOf(Categoria::class,$categoriaModel);
        $this->assertEquals($model->publicId,$categoriaModel->publicId);
        $this->assertEquals($model->nombre,$categoriaModel->nombre);
    }


    public function test_ShouldMapCategoriaDTO(){

        $model= new Categoria(); 
        $model->publicId=uniqid();
        $model->nombre="productoPrueba";

        $json= json_encode($model);

        $jsonParsed=json_decode($json);

        $categoriaModel= $this->categoriaMapper->reverse($jsonParsed);
        
        $this->assertInstanceOf(CategoriaDTO::class,$categoriaModel);
        $this->assertEquals($model->nombre,$categoriaModel->nombre);
        $this->assertEquals($model->publicId,$categoriaModel->publicId);

    }

}
