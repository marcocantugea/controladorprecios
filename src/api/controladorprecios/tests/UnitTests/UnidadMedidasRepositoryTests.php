<?php

namespace Tests\UnitTests;

use App\Contractors\Models\UnidadMedida;
use App\Repositories\UnidadMedidaRepository;
use Illuminate\Database\MySqlConnection;
use \Illuminate\Database\Query\Builder;
use \Illuminate\Support\Collection;
use Tests\TestCase;

class UnidadMedidasRepositoryTests extends TestCase{

    // /** @var UnidadMedidaRepository */
    private UnidadMedidaRepository $repository;
    private MySqlConnection $con;
    private Builder $queryBuilder;
    private Collection $collection;

    protected $db;

    protected function setUp(): void
    {
       parent::setUp();
       $this->con= $this->createMock(MySqlConnection::class);
       $this->queryBuilder= $this->createMock(Builder::class);
       $this->collection= $this->createMock(Collection::class);
       $this->repository= new UnidadMedidaRepository($this->con);

    }

    //TODO: Unit test

    public function test_ShouldGetById(){

        $id=uniqid();

        $this->con->expects($this->atLeastOnce())
                    ->method('table')
                    ->with('unidadesmedidas')
                    ->willReturn($this->queryBuilder)
                    ;
                    
        $this->queryBuilder->expects($this->atLeastOnce())
        ->method('where')
        ->with('publicId',$id)
        ->willReturn($this->queryBuilder);

        $this->queryBuilder->expects($this->atLeastOnce())
                            ->method('select')
                            ->with([
                                'publicId',
                                'codigo',
                                'unidadMedida',
                                'activo',
                                'created_at',
                                'updated_at',
                                'fecha_eliminado'
                            ])
                            ->willReturn($this->queryBuilder)
                            ;

        $this->queryBuilder->expects($this->atLeastOnce())
        ->method('first')
        ->willReturn([])
        ;

        $item=$this->repository->getById($id);
    }


}