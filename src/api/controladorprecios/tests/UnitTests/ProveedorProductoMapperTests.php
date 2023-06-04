<?php

namespace Tests\UnitTests;

use App\Contractors\Models\ProveedorProducto;
use App\DTOs\ProveedorProductoDTO;
use App\Mappers\ProveedorProductoMapper;
use DateTime;
use Tests\TestCase;

class ProveedorProductoMapperTests extends TestCase
{
    
    private ProveedorProductoMapper $mapper;

    public function setUp() : void{
        
        $this->mapper= new ProveedorProductoMapper();
    }

    public function test_ShouldMapProveedorProductoModel(){
        $dto= new ProveedorProductoDTO(uniqid(),uniqid(),"codigo");
        $dto->productoId=1;
        $dto->proveedorId=1;

        $model= $this->mapper->map($dto);

        $this->assertInstanceOf(ProveedorProducto::class,$model);
        $this->assertEquals($dto->productoId,$model->productoId);
        $this->assertEquals($dto->proveedorId,$model->proveedorId);
    }

    public function test_ShouldMapProveedorProductoDto(){
        $model= new ProveedorProducto(1,1,1,true,new DateTime(), new DateTime(),null);
        $model->productoPublicId=uniqid();
        $model->proveedorPublicId=uniqid();

        $dto= $this->mapper->reverse($model);

        $this->assertInstanceOf(ProveedorProductoDTO::class,$dto);
        $this->assertEquals($model->productoPublicId,$dto->productoPublicId);
        $this->assertEquals($model->proveedorPublicId,$dto->proveedorPublicId);
    }
}
