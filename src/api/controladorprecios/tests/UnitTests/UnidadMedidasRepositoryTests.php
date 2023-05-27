<?php

namespace Tests\UnitTests;

use App\Contractors\Models\UnidadMedida;
use App\Repositories\UnidadMedidaRepository;
use Tests\TestCase;

class UnidadMedidasRepositoryTests extends TestCase{

    // /** @var UnidadMedidaRepository */
    private UnidadMedidaRepository $repository;
    protected $db;

    protected function setUp(): void
    {
       parent::setUp();
       $this->db=$this->app->make('db')->connection();     
       $this->repository= new UnidadMedidaRepository($this->db);

    }

    public function test_ShouldGetById(){
        $uom=$this->db->table('unidadesmedidas')->first();
        $item=$this->repository->getById($uom->publicId);
        $this->assertEquals($uom->publicId,$item->publicId);
    }


}