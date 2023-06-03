<?php 

namespace Tests\UnitTests;

use App\Contractors\Models\Proveedor;
use App\Contractors\Models\ProveedorInfoBasic;
use App\Contractors\Models\ProveedorMarca;
use App\Contractors\Models\ProveedorProducto;
use App\Repositories\ProveedoresRepository;
use Exception;
use Illuminate\Database\MySqlConnection;
use Tests\TestCase;
use \Illuminate\Database\Query\Builder;
use \Illuminate\Support\Collection;
use stdClass;

class ProveedoresRepositoryTests extends TestCase{

    private ProveedoresRepository $repository;
    private MySqlConnection $con;
    private Builder $queryBuilder;
    private Collection $collection;

    public function setUp():void{
        $this->con= $this->createMock(MySqlConnection::class);
        $this->queryBuilder= $this->createMock(Builder::class);
        $this->collection=$this->createMock(Collection::class);

        $this->repository=new ProveedoresRepository($this->con);
    }   

    public function test_ShouldAddModel_Success(){

        $model= new Proveedor("codigo","nombrecorto");

        $this->queryBuilder->expects($this->atLeastOnce())
                            ->method('where')
                            ->with(['codigo'=>$model->codigo],['nombreCotro'=>$model->nombreCorto])
                            ->willReturn($this->queryBuilder)
                            ;

        $this->queryBuilder->expects($this->once())
                            ->method('exists')
                            ->willReturn(false);

        $this->queryBuilder->expects($this->once())
                            ->method('insert');
        
        $this->con->expects($this->atLeastOnce())
                    ->method('table')
                    ->with('proveedores')
                    ->willReturn($this->queryBuilder)
                    ;

        $this->repository->add($model);
    }

    public function test_ShouldAddModel_Fail_NoProveedorModel(){

        $this->expectException(Exception::class);
        $this->repository->add(new stdClass());

    }

    public function test_ShouldAddModel_Fail_ProveedorExists(){
        $model= new Proveedor("codigo","nombrecorto");

        $this->queryBuilder->expects($this->atLeastOnce())
                            ->method('where')
                            ->with(['codigo'=>$model->codigo],['nombreCotro'=>$model->nombreCorto])
                            ->willReturn($this->queryBuilder)
                            ;

        $this->queryBuilder->expects($this->once())
                            ->method('exists')
                            ->willReturn(true);

        $this->con->expects($this->atLeastOnce())
                    ->method('table')
                    ->with('proveedores')
                    ->willReturn($this->queryBuilder)
                    ;

        $this->expectException(Exception::class);

        $this->repository->add($model);
    }

    public function test_ShouldUpdateModel_Success(){

        $model= new Proveedor("codigo","nombrecorto",publicId:uniqid());

        $this->queryBuilder->expects($this->atLeastOnce())
                            ->method('where')
                            ->with('publicId',$model->publicId)
                            ->willReturn($this->queryBuilder)
                            ;

        $this->queryBuilder->expects($this->once())
                            ->method('update')
                            ;
        
        $this->con->expects($this->atLeastOnce())
                    ->method('table')
                    ->with('proveedores')
                    ->willReturn($this->queryBuilder)
                    ;

        $this->repository->update($model);
    }

    public function test_ShouldUpdateModel_Fail_NoProveedorModel(){
        $this->expectException(Exception::class);
        $this->repository->update(new stdClass());
    }

    public function test_ShouldUpdateModel_fail_emptyPublicId(){
        $model= new Proveedor("codigo","nombrecorto");
        $this->expectException(Exception::class);
        $this->repository->update($model);
    }

    public function test_ShouldDeleteProveedor_Success(){
        
        $id=uniqid();

        $this->queryBuilder->expects($this->atLeastOnce())
                            ->method('where')
                            ->with('publicId',$id)
                            ->willReturn($this->queryBuilder)
                            ;

        $this->queryBuilder->expects($this->once())
        ->method('update')
        ;
           
        $this->con->expects($this->atLeastOnce())
                    ->method('table')
                    ->with('proveedores')
                    ->willReturn($this->queryBuilder)
                    ;

        $this->repository->delete($id);
    }

    public function test_ShouldDeleteProveedor_Fail_emptyId(){
        $this->expectException(Exception::class);
        $this->repository->delete("");
    }

    public function test_ShouldGetByIdProveedor(){

        $id=uniqid();

        $stdObject= json_decode(json_encode(new Proveedor("codigo","nombreCorto",publicId:uniqid())));
        
        $this->queryBuilder->expects($this->atLeastOnce())
                            ->method('where')
                            ->with('publicId',$id)
                            ->willReturn($this->queryBuilder)
        ;

        $this->queryBuilder->expects($this->atLeastOnce())
                            ->method('select')
                            ->with([
                                'id',
                                'publicId',
                                'codigo',
                                'nombreCorto',
                                'activo',
                                'created_at',
                                'updated_at',
                                'fecha_eliminado'
                            ])
                            ->willReturn($this->queryBuilder)
                            ;

        $this->queryBuilder->expects($this->atLeastOnce())
                            ->method('first')
                            ->willReturn($stdObject)
        ;

        $this->con->expects($this->atLeastOnce())
                    ->method('table')
                    ->with('proveedores')
                    ->willReturn($this->queryBuilder)
        ;

        $item=$this->repository->getById($id);

        $this->assertEquals($stdObject->publicId,$item->publicId);
        $this->assertEquals($stdObject->codigo,$item->codigo);
        $this->assertEquals($stdObject->nombreCorto,$item->nombreCorto);
    }

    public function test_ShouldAddProveedorInfoBasic_Success(){

        $model= new ProveedorInfoBasic("nombre","razonSocial","RFC");
        $model->proveedorId=1;

        $this->queryBuilder->expects($this->atLeastOnce())
                            ->method('where')
                            ->with(['proveedorId'=>$model->proveedorId])
                            ->willReturn($this->queryBuilder)
        ;

        $this->queryBuilder->expects($this->once())
                            ->method('whereNull')
                            ->with('fecha_eliminado')
                            ->willReturn($this->queryBuilder)
        ;

        $this->queryBuilder->expects($this->once())
                            ->method('exists')
                            ->willReturn(false)
        ;

        $this->queryBuilder->expects($this->once())
                            ->method('insert')
                            ->willReturn(false)
        ;

        $this->con->expects($this->atLeastOnce())
                    ->method('table')
                    ->with('proveedoresInfoBasic')
                    ->willReturn($this->queryBuilder)
        ;

        $this->repository->addProveedorInfoBasic($model);

    }

    public function test_ShouldAddProveedorInfoBasic_Fail_EmptyProveedorId(){
        $this->expectException(Exception::class);
        $model= new ProveedorInfoBasic("nombre","razonsocial","rfc");
        $this->repository->add($model);
    }

    public function test_ShouldAddModel_Fail_InfoBasicExist(){

        $model= new ProveedorInfoBasic("nombre","razonSocial","RFC");
        $model->proveedorId=1;

        $this->queryBuilder->expects($this->atLeastOnce())
                            ->method('where')
                            ->with(['proveedorId'=>$model->proveedorId])
                            ->willReturn($this->queryBuilder)
        ;

        $this->queryBuilder->expects($this->once())
                            ->method('whereNull')
                            ->with('fecha_eliminado')
                            ->willReturn($this->queryBuilder)
        ;

        $this->queryBuilder->expects($this->once())
                            ->method('exists')
                            ->willReturn(true)
        ;

        $this->con->expects($this->atLeastOnce())
                    ->method('table')
                    ->with('proveedoresInfoBasic')
                    ->willReturn($this->queryBuilder)
        ;

        $this->expectException(Exception::class);

        $this->repository->addProveedorInfoBasic($model);
    }

    public function test_ShouldUpdateProveedorInfoBasic_Success(){
        $model= new ProveedorInfoBasic("nombre","razonSocial","RFC",publicId:uniqid());

        $this->queryBuilder->expects($this->atLeastOnce())
                            ->method('where')
                            ->with('publicId',$model->publicId)
                            ->willReturn($this->queryBuilder)
        ;


        $this->queryBuilder->expects($this->once())
                            ->method('update')
                            ->willReturn(false)
        ;

        $this->con->expects($this->atLeastOnce())
                    ->method('table')
                    ->with('proveedoresInfoBasic')
                    ->willReturn($this->queryBuilder)
        ;

        $this->repository->updateProveedorInfoBasic($model);
    }

    public function test_ShoulDeleteProveedorInfoBasic_Success(){

        $id=uniqid();

        $this->queryBuilder->expects($this->atLeastOnce())
        ->method('where')
        ->with('publicId',$id)
        ->willReturn($this->queryBuilder)
        ;

        $this->queryBuilder->expects($this->once())
                            ->method('update')
                            ->willReturn(false)
        ;
        
        $this->con->expects($this->atLeastOnce())
                    ->method('table')
                    ->with('proveedoresInfoBasic')
                    ->willReturn($this->queryBuilder)
        ;

        $this->repository->deleteProveedorInfoBasic($id);
    }

    public function test_ShoulDeleteProveedorInfoBasic_Fail_emptyId(){
        $this->expectException(Exception::class);
        $this->repository->deleteProveedorInfoBasic("");
    }

    public function test_ShouldGetProveedorInfoBasic(){
        $model=new ProveedorInfoBasic("nombre","razonsocial","rfc",publicId:uniqid());
        $stdObject= json_decode(json_encode($model));

        $this->queryBuilder->expects($this->atLeastOnce())
        ->method('where')
        ->with('publicId', $model->publicId)
        ->willReturn($this->queryBuilder);

        $this->queryBuilder->expects($this->atLeastOnce())
            ->method('select')
            ->with([
                'id',
                'proveedorId',
                'publicId',
                'nombre',
                'rasonSocial',
                'RFC',
                'activo',
                'created_at',
                'updated_at',
                'fecha_eliminado'
            ])
            ->willReturn($this->queryBuilder);

        $this->queryBuilder->expects($this->atLeastOnce())
            ->method('first')
            ->willReturn($stdObject);


        $this->con->expects($this->atLeastOnce())
            ->method('table')
            ->with('proveedoresInfoBasic')
            ->willReturn($this->queryBuilder);


        $item=$this->repository->getProveedorInfoBasic($model->publicId);

    }

    public function test_ShouldGetInfoBasicProveedor(){

        $idProveedor=uniqid();
        $model=new ProveedorInfoBasic("nombre","razonsocial","rfc",publicId:uniqid());
        $stdObject= json_decode(json_encode($model));

        $this->queryBuilder->expects($this->atLeastOnce())
        ->method('join')
        ->with('proveedores', 'proveedoresInfoBasic.proveedorId', 'proveedores.id')
        ->willReturn($this->queryBuilder);

        $this->queryBuilder->expects($this->atLeastOnce())
        ->method('where')
        ->with('proveedores.publicId', $idProveedor)
        ->willReturn($this->queryBuilder);

        $this->queryBuilder->expects($this->atLeastOnce())
            ->method('select')
            ->with([
                'proveedoresInfoBasic.id',
                'proveedoresInfoBasic.proveedorId',
                'proveedoresInfoBasic.publicId',
                'proveedoresInfoBasic.nombre',
                'proveedoresInfoBasic.rasonSocial',
                'proveedoresInfoBasic.RFC',
                'proveedoresInfoBasic.activo',
                'proveedoresInfoBasic.created_at',
                'proveedoresInfoBasic.updated_at',
                'proveedoresInfoBasic.fecha_eliminado'
            ])
            ->willReturn($this->queryBuilder);

        $this->queryBuilder->expects($this->atLeastOnce())
            ->method('first')
            ->willReturn($stdObject);

        $this->con->expects($this->atLeastOnce())
        ->method('table')
        ->with('proveedoresInfoBasic')
        ->willReturn($this->queryBuilder);

        $item=$this->repository->getInfoBasicByProveedor($idProveedor);

        $this->assertEquals($model->publicId,$item->publicId);
    }

    public function test_ShouldAddProveedorMarca(){

        $model= new ProveedorMarca(1,1);

        $this->queryBuilder->expects($this->once())
                            ->method('insert');
        
        $this->con->expects($this->atLeastOnce())
                    ->method('table')
                    ->with('proveedoresmarcas')
                    ->willReturn($this->queryBuilder)
                    ;

        $this->repository->addProveedorMarca($model);
    }

    public function test_ShouldaddProveedorProducto(){

        $model= new ProveedorProducto(1,1);

        $this->queryBuilder->expects($this->once())
                            ->method('insert');
        
        $this->con->expects($this->atLeastOnce())
                    ->method('table')
                    ->with('proveedoresproductos')
                    ->willReturn($this->queryBuilder)
                    ;

        $this->repository->addProveedorProducto($model);
    }

    public function test_ShouldGetProveedorByCode(){

        $model=new Proveedor("codigo","nombrecorto",publicId:uniqid());
        $stdObject=json_decode(json_encode($model));

        $this->queryBuilder->expects($this->atLeastOnce())
            ->method('where')
            ->with('codigo',$model->codigo)
            ->willReturn($this->queryBuilder);

        $this->queryBuilder->expects($this->atLeastOnce())
            ->method('select')
            ->with([
                'id',
                'publicId',
                'codigo',
                'nombreCorto',
                'activo',
                'created_at',
                'updated_at',
                'fecha_eliminado'
            ])
            ->willReturn($this->queryBuilder);

        $this->queryBuilder->expects($this->atLeastOnce())
            ->method('first')
            ->willReturn($stdObject);


        $this->con->expects($this->atLeastOnce())
            ->method('table')
            ->with('proveedores')
            ->willReturn($this->queryBuilder);

        $item=$this->repository->getProveedorByCode($model->codigo);

        $this->assertEquals($model->publicId,$item->publicId);
    }

    public function getProveedores_Succes_noparameters(){
        
        $offset=0;
        $limit=500;
        
        $this->queryBuilder->expects($this->atLeastOnce())
        ->method('leftJoin')
        ->with('proveedoresInfoBasic','proveedoresInfoBasic.proveedorId','proveedores.id')
        ->willReturn($this->queryBuilder);

        $this->queryBuilder->expects($this->atLeastOnce())
        ->method('whereNull')
        ->with(['proveedores.fecha_eliminado'])
        ->willReturn($this->queryBuilder);

        $this->queryBuilder->expects($this->atLeastOnce())
        ->method('select')
        ->with([
            'proveedores.id as proveedorId',
            'proveedores.publicId as proveedorPublicId',
            'proveedores.codigo',
            'proveedores.nombreCorto',
            'proveedores.activo as proveedorActivo',
            'proveedores.created_at as proveedorCreated_at',
            'proveedores.updated_at as proveedorUpdated_at',
            'proveedores.fecha_eliminado as ProveedorFecha_eliminado',
            'proveedoresInfoBasic.id as infoBasicId',
            'proveedoresInfoBasic.proveedorId',
            'proveedoresInfoBasic.publicId as infoBasicPublicId',
            'proveedoresInfoBasic.nombre',
            'proveedoresInfoBasic.rasonSocial',
            'proveedoresInfoBasic.RFC',
            'proveedoresInfoBasic.activo as infoBasicActivo',
            'proveedoresInfoBasic.created_at as infoBasicCreated_at',
            'proveedoresInfoBasic.updated_at  as infoBasicUpdated_at',
            'proveedoresInfoBasic.fecha_eliminado  as infoBasicFecha_eliminado'
        ])
        ->willReturn($this->queryBuilder);

        $this->queryBuilder->expects($this->atLeastOnce())
        ->method('skip')
        ->with($offset)
        ->willReturn($this->queryBuilder);

        $this->queryBuilder->expects($this->atLeastOnce())
        ->method('take')
        ->with($this->queryBuilder)
        ->willReturn($limit);

        $this->queryBuilder->expects($this->atLeastOnce())
        ->method('get')
        ->willReturn([]);

        $this->con->expects($this->atLeastOnce())
        ->method('table')
        ->with('proveedores')
        ->willReturn($this->queryBuilder);

        $items= $this->repository->getProveedores([],$limit,$offset,true);


    }

    public function getProveedores_Succes_withparameters(){
        
        $offset=0;
        $limit=500;
        $parameters=[["codigo"=>["1233","="]],["codigo"=>["1233","="]]];
        
        $this->queryBuilder->expects($this->atLeastOnce())
        ->method('leftJoin')
        ->with('proveedoresInfoBasic','proveedoresInfoBasic.proveedorId','proveedores.id')
        ->willReturn($this->queryBuilder);

        $this->queryBuilder->expects($this->atLeastOnce())
        ->method('where')
        ->willReturn($this->queryBuilder);

        $this->queryBuilder->expects($this->atLeastOnce())
        ->method('whereNull')
        ->with(['proveedores.fecha_eliminado'])
        ->willReturn($this->queryBuilder);

        $this->queryBuilder->expects($this->atLeastOnce())
        ->method('select')
        ->with([
            'proveedores.id as proveedorId',
            'proveedores.publicId as proveedorPublicId',
            'proveedores.codigo',
            'proveedores.nombreCorto',
            'proveedores.activo as proveedorActivo',
            'proveedores.created_at as proveedorCreated_at',
            'proveedores.updated_at as proveedorUpdated_at',
            'proveedores.fecha_eliminado as ProveedorFecha_eliminado',
            'proveedoresInfoBasic.id as infoBasicId',
            'proveedoresInfoBasic.proveedorId',
            'proveedoresInfoBasic.publicId as infoBasicPublicId',
            'proveedoresInfoBasic.nombre',
            'proveedoresInfoBasic.rasonSocial',
            'proveedoresInfoBasic.RFC',
            'proveedoresInfoBasic.activo as infoBasicActivo',
            'proveedoresInfoBasic.created_at as infoBasicCreated_at',
            'proveedoresInfoBasic.updated_at  as infoBasicUpdated_at',
            'proveedoresInfoBasic.fecha_eliminado  as infoBasicFecha_eliminado'
        ])
        ->willReturn($this->queryBuilder);

        $this->queryBuilder->expects($this->atLeastOnce())
        ->method('skip')
        ->with($offset)
        ->willReturn($this->queryBuilder);

        $this->queryBuilder->expects($this->atLeastOnce())
        ->method('take')
        ->with($this->queryBuilder)
        ->willReturn($limit);

        $this->queryBuilder->expects($this->atLeastOnce())
        ->method('get')
        ->willReturn([]);

        $this->con->expects($this->atLeastOnce())
        ->method('table')
        ->with('proveedores')
        ->willReturn($this->queryBuilder);

        $items= $this->repository->getProveedores([],$limit,$offset,true);


    }
}