<?php

namespace Tests\UnitTests;

use App\Contractors\Models\Categoria;
use App\Contractors\Models\Usuario;
use App\Repositories\UsuariosRepository;
use Tests\TestCase;
use Illuminate\Database\MySqlConnection;
use DateTime;
use Exception;

class UsuariosRepositoryTests extends TestCase
{
 
    private UsuariosRepository $repository;
    /**@var MySqlConnection */
    private $MysqlConnection;

    public function SetUp():void{

        parent::setUp();
        $this->MysqlConnection= $this->createMock(MySqlConnection::class);

        $this->repository= new UsuariosRepository($this->MysqlConnection);
    }

    public function test_ShouldAddUsuario(){
        $queryBuilder=$this->createMock(\Illuminate\Database\Query\Builder::class);
        $this->MysqlConnection->expects($this->atLeastOnce())->method('table')->with("usuarios")->willReturn($queryBuilder);
        $queryBuilder->expects($this->atLeastOnce())->method('insert');
        $this->repository->add(new Usuario("usuario"));
    }

    public function test_ShouldAddUsuario_FailNoUsuarioclass(){
        $this->expectException(Exception::class);
        $this->repository->add(new Categoria("nombre"));
    }

    public function test_ShouldDeleteUsuario(){
        $queryBuilder=$this->createMock(\Illuminate\Database\Query\Builder::class);
        $this->MysqlConnection->expects($this->atLeastOnce())->method('table')->with('usuarios')->willReturn($queryBuilder);
        $queryBuilder->expects($this->atLeastOnce())->method('where')->willReturn($queryBuilder);
        $queryBuilder->expects($this->atLeastOnce())->method('update');
        $this->repository->delete(new Usuario("newUsuario"));
    }

    public function test_ShouldDeleteUsuario_Fail_EmptyId(){
        $this->expectException(Exception::class);
        $this->repository->delete("");
    }

    public function test_ShouldUpdateUsuario(){
        $queryBuilder=$this->createMock(\Illuminate\Database\Query\Builder::class);
        $this->MysqlConnection->expects($this->atLeastOnce())->method('table')->with("usuarios")->willReturn($queryBuilder);
        $queryBuilder->expects($this->atLeastOnce())->method('where')->willReturn($queryBuilder);
        $queryBuilder->expects($this->atLeastOnce())->method('update');
        $this->repository->update(new Usuario("newUsuario",publicId:uniqid()));
    }

    public function test_ShouldUpdateUsuario_Fail_NoUsuarioModel(){
        $this->expectException(Exception::class);
        $this->repository->update(new Usuario("newUsuario"));
    }

    public function test_ShouldGetById(){
        $queryBuilder=$this->createMock(\Illuminate\Database\Query\Builder::class);
        $this->MysqlConnection->expects($this->atLeastOnce())->method('table')->with("usuarios")->willReturn($queryBuilder);
        $queryBuilder->expects($this->atLeastOnce())->method('where')->willReturn($queryBuilder);
        $queryBuilder->expects($this->atLeastOnce())->method('select')->willReturn($queryBuilder);
        $queryBuilder->expects($this->atLeastOnce())->method('first');
        $response=$this->repository->getById(uniqid());
    }

    public function test_ShouldGetUserByName(){
        $fields=[
            'publicId',
            'user',
            'hash',
            'email',
            'active',
            'created_at',
            'updated_at',
            'deleted_at'
        ];

        $queryBuilder=$this->createMock(\Illuminate\Database\Query\Builder::class);
        $this->MysqlConnection->expects($this->atLeastOnce())->method('table')->with("usuarios")->willReturn($queryBuilder);
        $queryBuilder->expects($this->atLeastOnce())->method('where')->with("user","usuario1")->willReturn($queryBuilder);
        $queryBuilder->expects($this->atLeastOnce())->method('select')->with($fields)->willReturn($queryBuilder);
        $queryBuilder->expects($this->atLeastOnce())->method('first');
        $response=$this->repository->getUsuario("usuario1");
    }

}
