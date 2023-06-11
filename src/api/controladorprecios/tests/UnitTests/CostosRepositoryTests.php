<?php

namespace Tests\UnitTests;

use App\Contractors\Models\Costo;
use App\Contractors\Repositories\ICostosRepository;
use App\DTOs\CostoDTO;
use App\Repositories\CostosRepository;
use DateTime;
use Exception;
use Illuminate\Database\MySqlConnection;
use \Illuminate\Database\Query\Builder;
use \Illuminate\Support\Collection;
use Tests\TestCase;

class CostosRepositoryTests extends TestCase
{
    
    private MySqlConnection $con;
    private Builder $queryBuilder;
    private Collection $collection;
    private ICostosRepository $repository;

    public function setUp() : void {
        
        $this->con= $this->createMock(MySqlConnection::class);
        $this->queryBuilder=$this->createMock(Builder::class);
        $this->collection=$this->createMock(Collection::class);
        $this->repository= new CostosRepository($this->con);

    }

    public function test_ShouldAddModel_Success(){

        $model= new Costo(1,1,874.39);

        $this->queryBuilder->expects($this->once())
        ->method('insert');

        $this->con->expects($this->atLeastOnce())
        ->method('table')
        ->with('costos')
        ->willReturn($this->queryBuilder);

        $this->repository->add($model);
    }

    public function test_ShouldAddModel_Fail_NoInstanceOfCosto(){

        $this->expectException(Exception::class);
        $this->repository->add(new CostoDTO(uniqid(),uniqid(),0));

    }

    public function test_ShouldAddModel_Fail_NoProductId(){
        $this->expectException(Exception::class);
        $this->repository->add(new Costo(0,0,0));
    }

    public function test_ShouldUpdateModel_Success(){

        $model= new Costo(1,1,345.3454,1,uniqid(),true,new DateTime(),expira_en:new DateTime());

        $this->queryBuilder->expects($this->once())
        ->method('where')
        ->with('publicId',$model->publicId)
        ->willReturn($this->queryBuilder);

        $this->queryBuilder->expects($this->once())
        ->method('update')
        ;

        $this->con->expects($this->atLeastOnce())
        ->method('table')
        ->with('costos')
        ->willReturn($this->queryBuilder);

        $this->repository->update($model);

    }

    public function test_ShouldUpdateModel_Fail_NoInstaceOfCosto(){
        $this->expectException(Exception::class);
        $this->repository->update(new CostoDTO(uniqid(),uniqid(),344));
    }

    public function test_ShouldUpdateModel_Fail_EmptyId(){
        $this->expectException(Exception::class);
        $this->repository->update(new Costo(1,1,0));
    }

    public function test_ShouldDelete_Success(){

        $id=uniqid();

        $this->queryBuilder->expects($this->atLeastOnce())
        ->method('where')
        ->with('publicId',$id)
        ->willReturn($this->queryBuilder);

        $this->queryBuilder->expects($this->once())
        ->method('update');

        $this->con->expects($this->atLeastOnce())
        ->method('table')
        ->with('costos')
        ->willReturn($this->queryBuilder);

        $this->repository->delete($id);

    }

    public function test_ShouldDelete_Fail_EmptyId(){

        $this->expectException(Exception::class);
        $this->repository->delete("");

    }

    public function test_ShouldGetById_Success(){

        $id=uniqid();

        $this->con->expects($this->atLeastOnce())
        ->method('table')
        ->with('costos')
        ->willReturn($this->queryBuilder);

        $this->queryBuilder->expects($this->atLeastOnce())
        ->method('where')
        ->with('publicId',$id)
        ->willReturn($this->queryBuilder);

        $this->queryBuilder->expects($this->once())
        ->method('select')
        ->with([
            'Id',
            'publicId',
            'productoId',
            'proveedorId',
            'costo',
            'activo',
            'expira_en',
            'created_at',
            'updated_at',
            'fecha_eliminado'
        ])
        ->willReturn($this->queryBuilder);

        $this->queryBuilder->expects($this->once())
        ->method('get');

        $this->repository->getById($id);
    }

    public function test_ShouldGetCostosByProveedor_Success(){

        $id=uniqid();
        $costo1= new Costo(1,1,234.342,1,uniqid(),true,new DateTime(),null,null,new DateTime());
        $costo2= new Costo(1,1,234.342,1,uniqid(),true,new DateTime(),null,null,new DateTime());
        $costo3= new Costo(1,1,234.342,1,uniqid(),true,new DateTime(),null,null,new DateTime());

        $items=[$costo1,$costo2,$costo3];

        $this->con->expects($this->atLeastOnce())
        ->method('table')
        ->with('costos')
        ->willReturn($this->queryBuilder);

        $this->queryBuilder->expects($this->atLeastOnce())
        ->method('leftJoin')
        ->willReturn($this->queryBuilder);

        $this->queryBuilder->expects($this->once())
        ->method('where')
        ->with('proveedores.publicId',$id)
        ->willReturn($this->queryBuilder);

        $this->queryBuilder->expects($this->once())
        ->method('whereNull')
        ->with('fecha_eliminado')
        ->willReturn($this->queryBuilder);

        $this->queryBuilder->expects($this->once())
        ->method('select')
        ->with([
            'costos.id',
            'costos.publicId',
            'costos.productoId',
            'costos.proveedorId',
            'costos.costo',
            'costos.activo',
            'costos.created_at',
            'costos.updated_at',
            'costos.expira_en',
            'costos.fecha_eliminado',
            'proveedores.publicId as proveedorPublicId',
            'proveedores.codigo',
            'proveedores.nombreCorto',
            'productos.publicId as productoPublicId',
            'productos.nombre as nombreProducto'
        ])
        ->willReturn($this->queryBuilder);

        $this->queryBuilder->expects($this->once())
        ->method('get')
        ->willReturn($items);

        $itemsFound= $this->repository->getCostosByProveedor($id);

        $this->assertEquals(count($items),count($itemsFound));

    }

    public function test_ShouldGetCostosByProveedor_Fail_emptyProveedorId(){
        $this->expectException(Exception::class);
        $this->repository->getCostosByProveedor("");
    }

    public function test_ShouldGetIdCostosByProveedorandProductoId_Success(){

        $idProveedor=uniqid();
        $idProducto=uniqid();

        $costo1= new Costo(1,1,234.342,1,uniqid(),true,new DateTime(),null,null,new DateTime());

        $this->con->expects($this->atLeastOnce())
        ->method('table')
        ->with('costos')
        ->willReturn($this->queryBuilder);

        $this->queryBuilder->expects($this->atLeastOnce())
        ->method('leftJoin')
        ->willReturn($this->queryBuilder);

        $this->queryBuilder->expects($this->once())
        ->method('where')
        ->with(['proveedores.publicId'=>$idProveedor,'productos.publicId'=>$idProducto])
        ->willReturn($this->queryBuilder);

        $this->queryBuilder->expects($this->once())
        ->method('select')
        ->with([
            'costos.publicId',
        ])
        ->willReturn($this->queryBuilder)
        ;

        $this->queryBuilder->expects($this->once())
        ->method('first')
        ->willReturn($costo1);

        $this->repository->getIdCostoByProveedorAndProductoId($idProveedor,$idProducto);
        
    }

    public function test_ShouldGetIdCostosByProveedorandProductoId_Fail_EmptyProducId(){
        $this->expectException(Exception::class);
        $this->repository->getIdCostoByProveedorAndProductoId("",uniqid());
    }

}
