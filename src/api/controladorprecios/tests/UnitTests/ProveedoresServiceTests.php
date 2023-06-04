<?php

namespace Tests\UnitTests;

use App\Contractors\IMapper;
use App\Contractors\Models\Proveedor;
use App\Contractors\Repositories\IProveedorRepository;
use App\DTOs\ProveedorDTO;
use App\Services\ProveedoresService;
use Exception;
use Tests\TestCase;

class ProveedoresServiceTests extends TestCase{

    private ProveedoresService $service;
    private IProveedorRepository $repository;
    private IMapper $proveedorMapper;
    private IMapper $proveedorInfoBasicMapper;

    public function setUp():void{

        $this->repository= $this->createMock(IProveedorRepository::class);
        $this->proveedorMapper=$this->createMock(IMapper::class);
        $this->proveedorInfoBasicMapper=$this->createMock(IMapper::class);

        $this->service= new ProveedoresService($this->repository,$this->proveedorMapper,$this->proveedorInfoBasicMapper);

    }

    public function test_ShouldAddProveedor_Success(){

        $dto= new ProveedorDTO("codig1","nombre corto");
        $model=new Proveedor($dto->codigo,$dto->nombreCorto);

        $this->proveedorMapper->expects($this->atLeastOnce())
        ->method('map')
        ->with($dto)
        ->willReturn($model)
        ;

        $this->repository->expects($this->atLeastOnce())
        ->method('add')
        ->with($model);

        $this->repository->expects($this->atLeastOnce())
        ->method('getProveedorByCode')
        ->with($model->codigo)
        ->willReturn($model)
        ;

        $this->proveedorMapper->expects($this->atLeastOnce())
        ->method('reverse')
        ->with($model)
        ->willReturn($model);

        $item=$this->service->addProveedor($dto);
    }

    public function test_ShouldAddProveedor_Fail(){

        $dto= new ProveedorDTO("codig1","nombre corto");
        $model=new Proveedor($dto->codigo,$dto->nombreCorto);

        $this->proveedorMapper->expects($this->atLeastOnce())
        ->method('map')
        ->with($dto)
        ->willThrowException(new Exception("exception rised"))
        ;

        $this->expectException(Exception::class);

        $item=$this->service->addProveedor($dto);
    }

}