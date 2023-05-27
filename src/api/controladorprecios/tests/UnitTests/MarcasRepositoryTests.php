<?php 

namespace Tests\UnitTests;

use App\Contractors\Models\Marca;
use App\Contractors\Repositories\IMarcaRepository;
use App\DTOs\CategoriaDTO;
use App\Repositories\MarcasRepository;
use Exception;
use Illuminate\Database\MySqlConnection;
use Tests\TestCase;

class MarcasRepositoryTests extends TestCase{

    private MarcasRepository $repository;
    private $MysqlConnection;

    public function SetUp():void{

        parent::setUp();
        $this->MysqlConnection= $this->createMock(MySqlConnection::class);

        $this->repository= new MarcasRepository($this->MysqlConnection);
    }

    public function test_ShouldAddMarcaModel(){
        $queryBuilder=$this->createMock(\Illuminate\Database\Query\Builder::class);
        $this->MysqlConnection->expects($this->atLeastOnce())->method('table')->with('marcas')->willReturn($queryBuilder);
        $queryBuilder->expects($this->atLeastOnce())->method('insert');
        $this->repository->add(new Marca("newatributo"));
    }

    public function test_ShouldAddMarcaModel_FailNoAtributoclass(){
        $this->expectException(Exception::class);
        $this->repository->add(new CategoriaDTO("nombre"));
    }

    public function test_ShouldDeleteMarca(){
        $queryBuilder=$this->createMock(\Illuminate\Database\Query\Builder::class);
        $this->MysqlConnection->expects($this->atLeastOnce())->method('table')->with('marcas')->willReturn($queryBuilder);
        $queryBuilder->expects($this->atLeastOnce())->method('where')->willReturn($queryBuilder);
        $queryBuilder->expects($this->atLeastOnce())->method('update');
        $this->repository->delete(new Marca("newatributo"));
    }

    public function test_ShouldDeleteAtributo_Fail_EmptyId(){
        $this->expectException(Exception::class);
        $this->repository->delete("");
    }

    public function test_ShouldUpdateMarca(){
        $queryBuilder=$this->createMock(\Illuminate\Database\Query\Builder::class);
        $this->MysqlConnection->expects($this->atLeastOnce())->method('table')->with('marcas')->willReturn($queryBuilder);
        $queryBuilder->expects($this->atLeastOnce())->method('where')->willReturn($queryBuilder);
        $queryBuilder->expects($this->atLeastOnce())->method('update');
        $this->repository->update(new Marca("newatributo",publicId:uniqid()));
    }

    public function test_ShouldUpdateMarca_Fail_NoAtributoModel(){
        $this->expectException(Exception::class);
        $this->repository->update(new CategoriaDTO("newatributo"));
    }

    public function test_ShouldGetById(){
        $queryBuilder=$this->createMock(\Illuminate\Database\Query\Builder::class);
        $this->MysqlConnection->expects($this->atLeastOnce())->method('table')->with('marcas')->willReturn($queryBuilder);
        $queryBuilder->expects($this->atLeastOnce())->method('where')->willReturn($queryBuilder);
        $queryBuilder->expects($this->atLeastOnce())->method('select')->willReturn($queryBuilder);
        $queryBuilder->expects($this->atLeastOnce())->method('first');
        $response=$this->repository->getById(uniqid());
    }

    public function test_ShoulGetMarcas_Success_noSearchParams(){
        $queryBuilder=$this->createMock(\Illuminate\Database\Query\Builder::class);
        $collectionClass=$this->createMock(\Illuminate\Support\Collection::class);
        $this->MysqlConnection->expects($this->atLeastOnce())->method('table')->with('marcas')->willReturn($queryBuilder);
        $queryBuilder->expects($this->atLeastOnce())->method('select')->willReturn($queryBuilder);
        $queryBuilder->expects($this->atLeastOnce())->method('get')->willReturn($collectionClass);
        $collectionClass->expects($this->once())->method('toArray')->willReturn([]);

        $items= $this->repository->getMarcas([]);
    }

    public function test_ShoulGetMarcas_Success_withSearchParams(){
        $queryBuilder=$this->createMock(\Illuminate\Database\Query\Builder::class);
        $collectionClass=$this->createMock(\Illuminate\Support\Collection::class);
        $this->MysqlConnection->expects($this->atLeastOnce())->method('table')->with('marcas')->willReturn($queryBuilder);
        $queryBuilder->expects($this->atLeastOnce())->method('where')->willReturn($queryBuilder);
        $queryBuilder->expects($this->atLeastOnce())->method('select')->willReturn($queryBuilder);
        $queryBuilder->expects($this->atLeastOnce())->method('get')->willReturn($collectionClass);
        $collectionClass->expects($this->once())->method('toArray')->willReturn([]);

        $items= $this->repository->getMarcas(["marca"=>"marca"]);
    }
}