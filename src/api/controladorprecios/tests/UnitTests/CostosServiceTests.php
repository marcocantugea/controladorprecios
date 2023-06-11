<?php

namespace Tests\UnitTests;

use App\Contractors\IMapper;
use App\Contractors\Models\Costo;
use App\Contractors\Repositories\ICostosRepository;
use App\DTOs\CostoDTO;
use App\Services\CostosService;
use DateTime;
use Exception;
use Tests\TestCase;

class CostosServiceTests extends TestCase{

    private CostosService $service;
    private ICostosRepository $repository;
    private IMapper $costosMapper;

    public function setUp(): void {

        $this->repository=$this->createMock(ICostosRepository::class);
        $this->costosMapper = $this->createMock(IMapper::class);

        $this->service= new CostosService($this->repository,$this->costosMapper);

    }


    public function test_ShouldAddCosto_Success(){

        $dto=new CostoDTO(uniqid(),uniqid(),48543.49,"codigoproveedor","nombrecorto","nombre producto",new DateTime());
        $dto->productoId=1;
        $dto->proveedorId=1;

        $model= new Costo($dto->proveedorId,$dto->productoId,$dto->costo,publicId:uniqid(),activo:true,create_at:new DateTime());

        $this->costosMapper->expects($this->atLeastOnce())
        ->method('map')
        ->with($dto)
        ->willReturn($model);

        $this->repository->expects($this->once())
        ->method('add')
        ->with($model);

        $this->service->addCosto($dto);

    }

    public function test_ShouldAddCosto_Fail_EmptyDTO(){
        
        $this->expectException(Exception::class);
        $dto=new CostoDTO(uniqid(),uniqid(),48543.49,"codigoproveedor","nombrecorto","nombre producto",new DateTime());
        $this->service->addCosto($dto);
    }

    public function test_ShouldAddCosto_Fail_ThrowingException(){
        
        $this->expectException(Exception::class);
        $dto=new CostoDTO(uniqid(),uniqid(),48543.49,"codigoproveedor","nombrecorto","nombre producto",new DateTime());
        $dto->productoId=1;
        $dto->proveedorId=1;

        $this->costosMapper->expects($this->atLeastOnce())
        ->method('map')
        ->with($dto)
        ->willThrowException(new Exception());

        $this->expectException(Exception::class);

        $this->service->addCosto($dto);

    }


    public function test_ShouldAddCostos_Success(){

        $dto=new CostoDTO(uniqid(),uniqid(),48543.49,"codigoproveedor","nombrecorto","nombre producto",new DateTime());
        $dto->productoId=1;
        $dto->proveedorId=1;

        $model= new Costo($dto->proveedorId,$dto->productoId,$dto->costo,publicId:uniqid(),activo:true,create_at:new DateTime());

        $this->costosMapper->expects($this->atLeastOnce())
        ->method('map')
        ->willReturn($model);

        $this->repository->expects($this->atLeastOnce())
        ->method('add')
        ->with($model);

        $this->service->addCostos([$dto,$dto,$dto]);

    }

    public function test_ShouldAddCostos_Fail_ArrayNoInstanceOfDTO(){

        $this->expectException(Exception::class);
        $dto=new CostoDTO(uniqid(),uniqid(),48543.49,"codigoproveedor","nombrecorto","nombre producto",new DateTime());
        $this->service->addCostos([$dto]);

    }

    public function test_ShouldAddCostos_Fail_ExceptionRised(){
        $this->expectException(Exception::class);

        $dto=new CostoDTO(uniqid(),uniqid(),48543.49,"codigoproveedor","nombrecorto","nombre producto",new DateTime());
        $dto->productoId=1;
        $dto->proveedorId=1;

        $this->costosMapper->expects($this->atLeastOnce())
        ->method('map')
        ->with($dto)
        ->willThrowException(new Exception());

        $this->expectException(Exception::class);

        $this->service->addCostos([$dto]);

    }

    public function test_ShouldUpdateCosto_Succes(){
        
        $dto=new CostoDTO(uniqid(),uniqid(),48543.49,"codigoproveedor","nombrecorto","nombre producto",new DateTime());
        $dto->productoId=1;
        $dto->proveedorId=1;

        $model= new Costo($dto->proveedorId,$dto->productoId,$dto->costo,publicId:uniqid(),activo:true,create_at:new DateTime());

        $this->costosMapper->expects($this->atLeastOnce())
        ->method('map')
        ->with($dto)
        ->willReturn($model);

        $this->repository->expects($this->atLeastOnce())
        ->method('update')
        ->with($model);


        $this->service->updateCosto($dto);

    }

    public function test_ShouldUpdateCosto_Fail_noIdsFounds(){

        $dto=new CostoDTO(uniqid(),uniqid(),48543.49,"codigoproveedor","nombrecorto","nombre producto",new DateTime());
        $dto->productoId=1;
        $dto->proveedorId=1;
        $model= new Costo($dto->proveedorId,$dto->productoId,$dto->costo,activo:true,create_at:new DateTime());

        $this->costosMapper->expects($this->atLeastOnce())
        ->method('map')
        ->with($dto)
        ->willReturn($model);

        $this->repository->expects($this->atLeastOnce())
        ->method('update')
        ->willThrowException(new Exception("no ids found"));

        $this->expectException(Exception::class);

        $this->service->updateCosto($dto);
        
    }

    public function test_ShouldUpdateCosto_Fail_throwException(){

        $dto=new CostoDTO(uniqid(),uniqid(),48543.49,"codigoproveedor","nombrecorto","nombre producto",new DateTime());

        $this->costosMapper->expects($this->atLeastOnce())
        ->method('map')
        ->with($dto)
        ->willThrowException(new Exception("fail"));

        $this->expectException(Exception::class);

        $this->service->updateCosto($dto);
    }

}