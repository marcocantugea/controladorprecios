<?php

namespace Tests\UnitTests;

use App\Contractors\Models\Proveedor;
use App\DTOs\ProveedorDTO;
use App\Mappers\ProveedorMapper;
use DateTime;
use Tests\TestCase;

class ProveedorMapperTests extends TestCase{

    private ProveedorMapper $mapper;

    public function setUp():void{
        $this->mapper=new ProveedorMapper();
    }

    public function test_ShouldMapProveedorDTOtoModel(){
        $dto= new ProveedorDTO("codigo","nombrecorto",uniqid(),true,new DateTime('now'),new DateTime(''),null);
        $model= $this->mapper->map($dto);
        $this->assertInstanceOf(Proveedor::class,$model);
        $this->assertEquals($dto->codigo,$model->codigo);
        $this->assertEquals($dto->nombreCorto,$model->nombreCorto);
        $this->assertEquals($dto->publicId,$model->publicId);
        $this->assertTrue($model->activo);
        $this->assertNotNull($model->created_at);
        $this->assertNotNull($model->updated_at);
        $this->assertNull($model->fecha_eliminado);
    }

    public function test_ShouldMapProveedorToDTO(){
        $model= new Proveedor("codigo","nombreCorto",1,uniqid(),true,new DateTime('now'),new DateTime(),null);
        $dto=$this->mapper->reverse($model);
        $this->assertInstanceOf(ProveedorDTO::class,$dto);
        $this->assertEquals($model->codigo,$dto->codigo);
        $this->assertEquals($model->nombreCorto,$dto->nombreCorto);
        $this->assertEquals($model->publicId,$dto->publicId);
        $this->assertTrue($dto->activo);
        $this->assertNotNull($dto->created_at);
        $this->assertNotNull($dto->updated_at);
        $this->assertNull($dto->fecha_eliminado);
    }

    public function test_ShouldMapStdClassToProveedorDTO(){
        $dto= new ProveedorDTO("codigo","nombrecorto",uniqid(),true,new DateTime('now'),new DateTime(''),null);
        $stdObj=json_decode(json_encode($dto));
        $dtoMapped=$this->mapper->reverse($stdObj);
        $this->assertInstanceOf(ProveedorDTO::class,$dtoMapped);
        $this->assertEquals($dto->codigo,$dtoMapped->codigo);
        $this->assertEquals($dto->nombreCorto,$dtoMapped->nombreCorto);
        $this->assertEquals($dto->publicId,$dtoMapped->publicId);
        $this->assertTrue($dtoMapped->activo);
        $this->assertNotNull($dtoMapped->created_at);
        $this->assertNotNull($dtoMapped->updated_at);
        $this->assertNull($dtoMapped->fecha_eliminado);
    }

    public function test_ShouldMapStdClassToProveedorModel(){
        $model= new Proveedor("codigo","nombreCorto",1,uniqid(),true,new DateTime('now'),new DateTime(),null);
        $stdObj=json_decode(json_encode($model));
        $modelMapped=$this->mapper->map($stdObj);
        $this->assertInstanceOf(Proveedor::class,$modelMapped);
        $this->assertEquals($model->codigo,$modelMapped->codigo);
        $this->assertEquals($model->nombreCorto,$modelMapped->nombreCorto);
        $this->assertEquals($model->publicId,$modelMapped->publicId);
        $this->assertTrue($modelMapped->activo);
        $this->assertNotNull($modelMapped->created_at);
        $this->assertNotNull($modelMapped->updated_at);
        $this->assertNull($modelMapped->fecha_eliminado);
    }
}