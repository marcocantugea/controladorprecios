<?php

namespace Tests\UnitTests;

use App\Contractors\Models\Costo;
use App\Contractors\Models\Producto;
use App\Contractors\Models\Proveedor;
use App\DTOs\CostoDTO;
use App\Mappers\CostoMapper;
use DateTime;
use Tests\TestCase;

class CostoMapperTests extends TestCase
{
    private CostoMapper $mapper;

    public function setUp() : void {
        $this->mapper= new CostoMapper();
    }

    public function test_ShouldMapCostoModelWithDTO(){
        $dto= new CostoDTO(uniqid(),uniqid(),192.4958,"codigoProveedor","nombre proveedor","nombreProducto",new DateTime(),new DateTime(),null);
        $dto->proveedorId=1;
        $dto->productoId=1;
        $model= $this->mapper->map($dto);
        $this->assertInstanceOf(Costo::class,$model);
        $this->assertEquals($dto->proveedorPublicId,$model->proveedorPublicId);
        $this->assertEquals($dto->productoPublicId,$model->productoPublicId);
        $this->assertEquals($dto->costo,$model->costo);
        $this->assertEquals($dto->created_at,$model->created_at);
        $this->assertEquals($dto->expiraEn,$model->expira_en);
        $this->assertInstanceOf(Proveedor::class,$model->proveedor);
        $this->assertInstanceOf(Producto::class,$model->producto);
        $this->assertEquals($dto->nombreCorto,$model->proveedor->nombreCorto);
        $this->assertEquals($dto->codigoProveedor,$model->proveedor->codigo);
        $this->assertEquals($dto->nombreProducto,$model->producto->nombre);
        $this->assertNull($model->fecha_eliminado);
    }

    public function test_ShouldMapCostoDTOWithModel(){
        $model= new Costo(1,
                          1,
                          394.3904,
                          1,
                          uniqid(),
                          true,
                          new DateTime(),
                          new DateTime(),
                          null,
                          new DateTime(),
        );  

        $model->proveedorPublicId=uniqid();
        $model->productoPublicId=uniqid();
        $model->proveedor = new Proveedor("codigo","nombrecorto",publicId:uniqid());
        $model->producto= new Producto();
        $model->producto->publicId=uniqid();
        $model->producto->nombre="nombre";

        $dto=$this->mapper->reverse($model);

        $this->assertInstanceOf(CostoDTO::class,$dto);
        $this->assertEquals($model->proveedorPublicId,$dto->proveedorPublicId);
        $this->assertEquals($model->productoPublicId,$dto->productoPublicId);
        $this->assertEquals($model->proveedor->codigo,$dto->codigoProveedor);
        $this->assertEquals($model->proveedor->nombreCorto,$dto->nombreCorto);
        $this->assertEquals($model->producto->nombre,$dto->nombreProducto);
        $this->assertNotNull($dto->expiraEn);
        $this->assertNotNull($dto->created_at);
        $this->assertNull($dto->fecha_eliminado);

    }

    public function test_ShouldMapCostoModelWithStdClass(){
        $dto= new CostoDTO(uniqid(),uniqid(),192.4958,"codigoProveedor","nombre proveedor","nombreProducto",new DateTime(),new DateTime(),null);
        $dto->proveedorId=1;
        $dto->productoId=1;

        $stdClass= json_decode(json_encode($dto));
        $model= $this->mapper->map($stdClass);
        $this->assertInstanceOf(Costo::class,$model);
        $this->assertEquals($dto->proveedorPublicId,$model->proveedorPublicId);
        $this->assertEquals($dto->productoPublicId,$model->productoPublicId);
        $this->assertEquals($dto->costo,$model->costo);
        $this->assertEquals($dto->created_at,$model->created_at);
        $this->assertEquals($dto->expiraEn,$model->expira_en);
        $this->assertInstanceOf(Proveedor::class,$model->proveedor);
        $this->assertInstanceOf(Producto::class,$model->producto);
        $this->assertEquals($dto->nombreCorto,$model->proveedor->nombreCorto);
        $this->assertEquals($dto->codigoProveedor,$model->proveedor->codigo);
        $this->assertEquals($dto->nombreProducto,$model->producto->nombre);
        $this->assertNull($model->fecha_eliminado);
    }

    public function test_ShouldMapCostoDTOWithStdClass(){

        $model= new Costo(1,
                1,
                394.3904,
                1,
                uniqid(),
                true,
                new DateTime(),
                new DateTime(),
                null,
                new DateTime(),
        );  

        $model->proveedorPublicId=uniqid();
        $model->productoPublicId=uniqid();
        $model->proveedor = new Proveedor("codigo","nombrecorto",publicId:uniqid());
        $model->producto= new Producto();
        $model->producto->publicId=uniqid();
        $model->producto->nombre="nombre";

        $stdClass= json_decode(json_encode($model));

        $dto= $this->mapper->reverse($stdClass);

        $this->assertInstanceOf(CostoDTO::class,$dto);
        $this->assertEquals($model->proveedorPublicId,$dto->proveedorPublicId);
        $this->assertEquals($model->productoPublicId,$dto->productoPublicId);
        $this->assertEquals($model->proveedor->codigo,$dto->codigoProveedor);
        $this->assertEquals($model->proveedor->nombreCorto,$dto->nombreCorto);
        $this->assertEquals($model->producto->nombre,$dto->nombreProducto);
        $this->assertNotNull($dto->expiraEn);
        $this->assertNotNull($dto->created_at);
        $this->assertNull($dto->fecha_eliminado);
    }
}
