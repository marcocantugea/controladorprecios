<?php

namespace Tests\UnitTests;

use App\Contractors\Models\Marca;
use App\Contractors\Models\Proveedor;
use App\Contractors\Models\ProveedorMarca;
use App\DTOs\MarcaDTO;
use App\DTOs\ProveedorMarcaDTO;
use App\Mappers\ProveedorMarcaMapper;
use DateTime;
use Tests\TestCase;

class ProveedorMarcaMapperTests extends TestCase{

    private ProveedorMarcaMapper $mapper;

    public function setUp() : void {

        parent::setUp();
        $this->mapper= new ProveedorMarcaMapper();

    }

    public function test_ShouldMapProveedorModel_constValirables(){

        $dto= new ProveedorMarcaDTO(uniqid(),uniqid(),"marca");
        $dto->marcaId=1;
        $dto->proveedorId=1;
        $model= $this->mapper->map($dto);

        $this->assertInstanceOf(ProveedorMarca::class,$model);
        $this->assertEquals($dto->proveedorId,$model->proveedorId);
        $this->assertEquals($dto->marcaId,$model->marcaId);
    }

    public function test_ShouldMapProveedorMarcaModel_ObjMarca(){

        $dto= new ProveedorMarcaDTO(uniqid(),uniqid(),"",new MarcaDTO("marca",uniqid(),true));
        $dto->marcaId=1;
        $dto->proveedorId=1;
        $model= $this->mapper->map($dto);

        $this->assertInstanceOf(ProveedorMarca::class,$model);
        $this->assertEquals($dto->proveedorId,$model->proveedorId);
        $this->assertEquals($dto->marcaId,$model->marcaId);
    }

    public function test_ShouldMapProveedorMarcaDTO(){
        $model= new ProveedorMarca(1,1,1,true,new DateTime(),new Datetime(),null);
        $model->marca= new Marca("marca",1,uniqid(),true,new DateTime(),new DateTime());
        $model->proveedor= new Proveedor("codigo","nombrecorto",1,uniqid(),true,new DateTime(),new DateTime(),null);

        $dto= $this->mapper->reverse($model);

        $this->assertInstanceOf(ProveedorMarcaDTO::class,$dto);
        $this->assertEquals($model->proveedor->publicId,$dto->proveedorPublicId);
        $this->assertNotNull($dto->marca);
        $this->assertEquals($model->marca->publicId,$dto->marca->publicId);

    }

    public function test_ShouldMapProveedorMarcaDTO_simple(){
        $model= new ProveedorMarca(1,1,1,true,new DateTime(),new Datetime(),null);
        $model->marcaPublicId=uniqid();
        $model->proveedorPublicId=uniqid();

        $dto= $this->mapper->reverse($model);

        $this->assertInstanceOf(ProveedorMarcaDTO::class,$dto);
        $this->assertEquals($model->proveedorPublicId,$dto->proveedorPublicId);
        $this->assertEquals($model->marcaPublicId,$dto->marca->publicId);
    }

    public function test_ShouldMapProveedorMarcaModelWithSTDClass(){
        $dto= new ProveedorMarcaDTO(uniqid(),uniqid(),"",new MarcaDTO("marca",uniqid(),true));
        $dto->marcaId=1;
        $dto->proveedorId=1;
        $stdObject=json_decode(json_encode($dto));
        $stdObject->id=1;
        $stdObject->activo=true;
        $stdObject->created_at=new DateTime();
        $stdObject->updated_at=new Datetime();
        $stdObject->fecha_eliminado=new Datetime();
        $model= $this->mapper->map($stdObject);

        $this->assertInstanceOf(ProveedorMarca::class,$model);
        $this->assertEquals($dto->proveedorId,$model->proveedorId);
        $this->assertEquals($dto->marcaId,$model->marcaId);
        $this->assertEquals($stdObject->id,$model->id);
        $this->assertTrue($model->activo);
        $this->assertNotNull($model->created_at);
        $this->assertNotNull($model->updated_at);
        $this->assertNotNull($model->fecha_eliminado);
    }

    public function test_ShouldMapProveedorMarcaDTOWithSTDClass_WithModel(){
        $model= new ProveedorMarca(1,1,1,true,new DateTime(),new Datetime(),null);
        $model->marca= new Marca("marca",1,uniqid(),true,new DateTime(),new DateTime());
        $model->proveedor= new Proveedor("codigo","nombrecorto",1,uniqid(),true,new DateTime(),new DateTime(),null);

        $stdObj= json_decode(json_encode($model));

        $dto=$this->mapper->reverse($stdObj);


        $this->assertInstanceOf(ProveedorMarcaDTO::class,$dto);
        $this->assertEquals($model->proveedor->publicId,$dto->proveedorPublicId);
        $this->assertEquals($model->marca->publicId,$dto->marca->publicId);
    }

    public function test_ShouldMapProveedorMarcaDTOWithSTDClass_WithOutModel(){
        $model= [
            "marcaPublicId"=>uniqid(),
            "proveedorPublicId"=>uniqid(),
            "marca"=>"marcapatito"
        ];

        $stdObj= json_decode(json_encode($model));

        $dto=$this->mapper->reverse($stdObj);


        $this->assertInstanceOf(ProveedorMarcaDTO::class,$dto);
        $this->assertEquals($model['proveedorPublicId'],$dto->proveedorPublicId);
        $this->assertEquals($model['marcaPublicId'],$dto->marca->publicId);
        $this->assertEquals($model['marca'],$dto->marca->marca);
    }

}