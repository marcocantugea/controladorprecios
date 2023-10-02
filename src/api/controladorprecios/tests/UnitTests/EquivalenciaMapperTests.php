<?php

namespace Tests\UnitTests;

use App\Contractors\Models\Equivalencia;
use App\DTOs\EquivalenciaDTO;
use App\DTOs\ProductoDTO;
use App\Mappers\EquivalenciaMapper;
use DateTime;
use Tests\TestCase;

class EquivalenciaMapperTests extends TestCase
{
    private EquivalenciaMapper $mapper;

    public function setUp() : void {
        $this->mapper =  new EquivalenciaMapper();
    }

    public function test_ShouldMapModelWithDTO(){
      $dto = new EquivalenciaDTO(uniqid(),uniqid(),uniqid(), new ProductoDTO("fakename","descripcion","codigo"));
      $dto->productoId=1;
      $dto->productoIdEqu=1;
      $model= $this->mapper->map($dto);
      $this->assertEquals($dto->productoId,$model->productoId);
      $this->assertEquals($dto->productoIdEqu,$model->productoIdEqu);
      $this->assertEquals($dto->productoPublicId,$model->productoPublicId);
      $this->assertEquals($dto->productoPublicIdEqu,$model->productoPublicIdEqu);
      $this->assertEquals($dto->publicId,$model->publicId);

    }

    public function test_ShouldMapDTOWithModel(){
        
        $model= new Equivalencia(1,1,1,uniqid(),uniqid(),uniqid(),new DateTime(),new DateTime(),null);
        $dto= $this->mapper->reverse($model);
        $this->assertEquals($model->publicId,$dto->publicId);
        $this->assertEquals($model->productoPublicIdEqu,$dto->productoPublicIdEqu);
        $this->assertEquals($model->productoIdEqu,$dto->productoIdEqu);
        $this->assertEquals($model->productoId,$dto->productoId);
        $this->assertEquals($model->productoPublicId,$dto->productoPublicId);

    }

    public function test_ShouldMapModelWithStdClass(){
        $dto = new EquivalenciaDTO(uniqid(),uniqid(),uniqid(), new ProductoDTO("fakename","descripcion","codigo"));
        $dto->productoId=1;
        $dto->productoIdEqu=1;

        $stdObj= json_decode(json_encode($dto));
        $model= $this->mapper->map($stdObj);
        $this->assertEquals($dto->productoId,$model->productoId);
        $this->assertEquals($dto->productoIdEqu,$model->productoIdEqu);
        $this->assertEquals($dto->productoPublicId,$model->productoPublicId);
        $this->assertEquals($dto->productoPublicIdEqu,$model->productoPublicIdEqu);
        $this->assertEquals($dto->publicId,$model->publicId);
  
    }

    public function test_ShouldMapCostoDTOWithStdClass(){

        $model= new Equivalencia(1,1,1,uniqid(),uniqid(),uniqid(),new DateTime(),new DateTime(),null);
        $stdObj= json_decode(json_encode($model));
        $dto= $this->mapper->reverse($stdObj);
        $this->assertEquals($model->publicId,$dto->publicId);
        $this->assertEquals($model->productoPublicIdEqu,$dto->productoPublicIdEqu);
        $this->assertEquals($model->productoIdEqu,$dto->productoIdEqu);
        $this->assertEquals($model->productoId,$dto->productoId);
        $this->assertEquals($model->productoPublicId,$dto->productoPublicId);

    }

}
