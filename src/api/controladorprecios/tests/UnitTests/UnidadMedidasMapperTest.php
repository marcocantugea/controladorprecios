<?php 

namespace Tests\UnitTests;

use App\Contractors\Models\UnidadMedida;
use App\DTOs\UnidadMedidaDTO;
use App\Mappers\UnidadMedidaMapper;
use DateTime;
use Tests\TestCase;

class UnidadMedidasMapperTest extends TestCase
{
    private UnidadMedidaMapper $mapper;

    protected function setUp(): void
    {
       parent::setUp();
       $this->mapper= new UnidadMedidaMapper();
    }

    public function test_ShouldMapUnidadMedidadDTO(){

        $dto=new UnidadMedidaDTO("codigo","codigo",uniqid(),true);
        $model= $this->mapper->map($dto);

        $this->assertInstanceOf(UnidadMedida::class,$model);
        $this->assertEquals($dto->publicId,$model->publicId);
        $this->assertEquals($dto->codigo,$model->codigo);
        $this->assertEquals($dto->unidadDeMedida,$model->unidadDeMedida);
    }

    public function test_ShouldMapMedidaModel(){

        $model=new UnidadMedida("codigo","fake",1,uniqid(),true,new DateTime('now'), new DateTime('now'),new DateTime('now'));
        $dto= $this->mapper->reverse($model);

        $this->assertInstanceOf(UnidadMedidaDTO::class,$dto);
        $this->assertEquals($model->publicId,$dto->publicId);
        $this->assertEquals($model->codigo,$dto->codigo);
        $this->assertEquals($model->unidadDeMedida,$dto->unidadDeMedida);
        $this->assertTrue($dto->activo);

    }
}

