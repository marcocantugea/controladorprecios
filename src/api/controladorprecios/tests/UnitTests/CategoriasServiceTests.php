<?php

namespace Tests\UnitTests;

use App\Contractors\IMapper;
use App\Contractors\Models\Categoria;
use App\Contractors\Repositories\ICategoriaRepository;
use App\DTOs\CategoriaDTO;
use App\Services\CategoriaService;
use Tests\TestCase;
use DateTime;
use Exception;

class CategoriasServiceTests extends TestCase
{

    protected $db;
    protected CategoriaService $productoService;
    protected ICategoriaRepository $categoriaRepositoryMock;
    protected IMapper $categoriaMapper;
    
    protected function setUp(): void
    {
       parent::setUp();
       $this->db=$this->app->make('db')->connection();
       
       $this->categoriaRepositoryMock=$this->getMockBuilder(ICategoriaRepository::class)
                                                ->onlyMethods(['add','update','delete','getById','searchCategory'])
                                                ->getMock();

       $this->categoriaMapper=$this->getMockBuilder(IMapper::class)
                                        ->onlyMethods(['map','reverse'])
                                        ->getMock();

       $this->productoService= new CategoriaService($this->categoriaRepositoryMock,$this->categoriaMapper);
    }

    public function test_AddCategoria_Sucess(){

        $categoriaToAdd= new Categoria();
        $categoriaToAdd->publicId=uniqid();
        $categoriaToAdd->nombre="categoriaPrueba";
        $categoriaToAdd->created_at=new DateTime('now');
        $categoriaToAdd->activo=true;

        $this->categoriaMapper->expects($this->once())
                            ->method('map')
                            ->willReturn($categoriaToAdd);

        $this->categoriaRepositoryMock->expects($this->once())
                                        ->method('add')
                                        ->with($this->equalTo($categoriaToAdd));

        $this->productoService->addCategoria(new CategoriaDTO($categoriaToAdd->nombre,true,new Datetime(),publicId:$categoriaToAdd->publicId));

    }

    public function test_AddCategoria_Fail_ThrowException(){

        $this->categoriaMapper->expects($this->once())
                            ->method('map')
                            ->will($this->throwException(new Exception("exception")));

        $this->expectException(Exception::class);

        $this->productoService->addCategoria(new CategoriaDTO("nombre",true,new Datetime(),publicId:uniqid()));
    }

    public function test_UpdateCategoria_Sucess(){

        $categoriaToAdd= new Categoria();
        $categoriaToAdd->publicId=uniqid();
        $categoriaToAdd->nombre="categoriaPrueba";
        $categoriaToAdd->created_at=new DateTime('now');
        $categoriaToAdd->activo=true;

        $this->categoriaMapper->expects($this->once())
                            ->method('map')
                            ->willReturn($categoriaToAdd);

        $this->categoriaRepositoryMock->expects($this->once())
                                        ->method('update')
                                        ->with($this->equalTo($categoriaToAdd));

        $this->productoService->updateCategoria(new CategoriaDTO($categoriaToAdd->nombre,true,new Datetime(),publicId:$categoriaToAdd->publicId));

    }

    public function test_updateCategoria_Fail_ThrowException(){

        $this->categoriaMapper->expects($this->once())
                            ->method('map')
                            ->will($this->throwException(new Exception("exception")));

        $this->expectException(Exception::class);

        $this->productoService->updateCategoria(new CategoriaDTO("nombre",true,new Datetime(),publicId:uniqid()));
    }


    public function test_deleteCategoria_Success(){

        $publicId=uniqid();

        $this->categoriaRepositoryMock->expects($this->once())
        ->method('delete')
        ->with($this->equalTo($publicId));

        $this->productoService->deleteCategoria($publicId);
    }

    public function test_deleteCategoria_Fail_ExceptionThrown(){

        $publicId=uniqid();

        $this->categoriaRepositoryMock->expects($this->once())
        ->method('delete')
        ->will($this->throwException(new Exception("exception")));

        $this->expectException(Exception::class);

        $this->productoService->deleteCategoria($publicId);
    }


}