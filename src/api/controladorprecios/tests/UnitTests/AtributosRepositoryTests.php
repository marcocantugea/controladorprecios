<?php

namespace Tests\UnitTests;

use App\Contractors\Models\Atributo;
use App\Contractors\Models\Categoria;
use App\DTOs\CategoriaDTO;
use App\Repositories\AtributosRepository;
use Exception;
use Illuminate\Database\MySqlConnection;
use Illuminate\Database\ConnectionInterface;
use Tests\TestCase;

class AtributosRepositoryTests extends TestCase
{
    
    private AtributosRepository $repository;
    private $MysqlConnection;

    public function SetUp():void{

        parent::setUp();
        $this->MysqlConnection= $this->createMock(MySqlConnection::class);

        $this->repository= new AtributosRepository($this->MysqlConnection);
    }

    public function test_ShouldAddAtributo(){
        $queryBuilder=$this->createMock(\Illuminate\Database\Query\Builder::class);
        $this->MysqlConnection->expects($this->atLeastOnce())->method('table')->willReturn($queryBuilder);
        $queryBuilder->expects($this->atLeastOnce())->method('insert');
        $this->repository->add(new Atributo("newatributo"));
    }

    public function test_ShouldAddAtributo_FailNoAtributoclass(){
        $this->expectException(Exception::class);
        $this->repository->add(new CategoriaDTO("nombre"));
    }

    public function test_ShouldDeleteAtributo(){
        $queryBuilder=$this->createMock(\Illuminate\Database\Query\Builder::class);
        $this->MysqlConnection->expects($this->atLeastOnce())->method('table')->willReturn($queryBuilder);
        $queryBuilder->expects($this->atLeastOnce())->method('where')->willReturn($queryBuilder);
        $queryBuilder->expects($this->atLeastOnce())->method('update');
        $this->repository->delete(new Atributo("newatributo"));
    }

    public function test_ShouldDeleteAtributo_Fail_EmptyId(){
        $this->expectException(Exception::class);
        $this->repository->delete("");
    }

    public function test_ShouldUpdateAtributo(){
        $queryBuilder=$this->createMock(\Illuminate\Database\Query\Builder::class);
        $this->MysqlConnection->expects($this->atLeastOnce())->method('table')->willReturn($queryBuilder);
        $queryBuilder->expects($this->atLeastOnce())->method('where')->willReturn($queryBuilder);
        $queryBuilder->expects($this->atLeastOnce())->method('update');
        $this->repository->update(new Atributo("newatributo",publicId:uniqid()));
    }

    public function test_ShouldUpdateAtributo_Fail_NoAtributoModel(){
        $this->expectException(Exception::class);
        $this->repository->update(new Categoria("newatributo"));
    }

    public function test_ShouldGetById(){
        $queryBuilder=$this->createMock(\Illuminate\Database\Query\Builder::class);
        $this->MysqlConnection->expects($this->atLeastOnce())->method('table')->willReturn($queryBuilder);
        $queryBuilder->expects($this->atLeastOnce())->method('where')->willReturn($queryBuilder);
        $queryBuilder->expects($this->atLeastOnce())->method('first');
        $response=$this->repository->getById(uniqid());
    }

    public function test_ShouldSearchAtributos(){

        $items=[
            "atributo"=>'search'
        ];

        $queryBuilder=$this->createMock(\Illuminate\Database\Query\Builder::class);
        $collectionMock=$this->createMock(\Illuminate\Support\Collection::class);
        $this->MysqlConnection->expects($this->atLeastOnce())->method('table')->willReturn($queryBuilder);
        $queryBuilder->expects($this->atLeastOnce())->method('where')->willReturn($queryBuilder);
        $queryBuilder->expects($this->atLeastOnce())->method('select')->willReturn($queryBuilder);
        $queryBuilder->expects($this->atLeastOnce())->method('get')->willReturn($collectionMock);
        $collectionMock->expects($this->atLeastOnce())->method('toArray')->willReturn($items);

        $itemsFound=$this->repository->searchAtributos($items);
    }
}
