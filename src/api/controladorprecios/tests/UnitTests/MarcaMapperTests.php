<?php

namespace Tests\UnitTests;

use App\Contractors\Models\Marca;
use App\DTOs\MarcaDTO;
use App\Mappers\MarcaMapper;
use DateTime;
use stdClass;
use Tests\TestCase;

class MarcaMapperTests extends TestCase
{
    private MarcaMapper $mapper;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mapper=new MarcaMapper();
    }


    public function test_ShouldMapMarcaModel(){
        $dto= new MarcaDTO("marca",uniqid(),true);
        $model= $this->mapper->map($dto);
        $this->assertInstanceOf(Marca::class,$model);
        $this->assertEquals($dto->marca,$model->marca);
        $this->assertEquals($dto->publicId,$model->publicId);
        $this->assertEquals($dto->activo,true);
    }

    public function test_ShouldMapMarcaDTO(){
        $model=new Marca("marca",1,uniqid(),true,new DateTime('now'),'2023-01-01 00:00:00',null);
        $dto= $this->mapper->reverse($model);
        $this->assertInstanceOf(MarcaDTO::class,$dto);
        $this->assertEquals($model->publicId,$dto->publicId);
        $this->assertEquals($model->marca,$dto->marca);
        $this->assertEquals($model->activo,$dto->activo);
    }

    public function test_ShouldMapStdClassToMarcaModel(){
        $model=new Marca("marca",1,uniqid(),true,new DateTime('now'),'2023-01-01 00:00:00',null);
        $stdClass=json_decode(json_encode($model));
        $modelMapped=$this->mapper->map($stdClass);
        $this->assertInstanceOf(Marca::class,$modelMapped);
        $this->assertEquals($model->marca,$modelMapped->marca);
        $this->assertEquals($model->publicId,$modelMapped->publicId);
        $this->assertEquals($model->activo,$modelMapped->activo);
        $this->assertInstanceOf(DateTime::class,$modelMapped->created_at);
        $this->assertInstanceOf(DateTime::class,$modelMapped->updated_at);
        $this->isNull($modelMapped->fecha_eliminado);

    }

    public function test_ShouldMappStdClassToMarcaDTO(){
        $model=new Marca("marca",1,uniqid(),true,new DateTime('now'),'2023-01-01 00:00:00',null);
        $stdClass=json_decode(json_encode($model));
        $dtoMapped=$this->mapper->reverse($stdClass);
        $this->assertInstanceOf(MarcaDTO::class,$dtoMapped);
        $this->assertEquals($model->publicId,$dtoMapped->publicId);
        $this->assertEquals($model->marca,$dtoMapped->marca);
        $this->assertEquals($model->activo,$dtoMapped->activo);
    }
}
