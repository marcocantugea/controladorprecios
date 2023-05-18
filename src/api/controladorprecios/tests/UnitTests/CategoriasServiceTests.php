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
use FastRoute\RouteParser\Std;
use stdClass;
use Throwable;

class CategoriasServiceTests extends TestCase
{

    protected $db;
    protected CategoriaService $categoriaService;
    protected ICategoriaRepository $categoriaRepositoryMock;
    protected IMapper $categoriaMapper;
    
    protected function setUp(): void
    {
       parent::setUp();
       $this->db=$this->app->make('db')->connection();
       
       $this->categoriaRepositoryMock=$this->getMockBuilder(ICategoriaRepository::class)
                                                ->onlyMethods(['add',
                                                            'update',
                                                            'delete',
                                                            'getById',
                                                            'searchCategory',
                                                            'addSubCategoria',
                                                            'addSubCategorias',
                                                            'getSubCategoria',
                                                            'hasSubCategorias'
                                                            ])
                                                ->getMock();

       $this->categoriaMapper=$this->getMockBuilder(IMapper::class)
                                        ->onlyMethods(['map','reverse'])
                                        ->getMock();

       $this->categoriaService= new CategoriaService($this->categoriaRepositoryMock,$this->categoriaMapper);
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

        $this->categoriaService->addCategoria(new CategoriaDTO($categoriaToAdd->nombre,true,new Datetime(),publicId:$categoriaToAdd->publicId));

    }

    public function test_AddCategoria_Fail_ThrowException(){

        $this->categoriaMapper->expects($this->once())
                            ->method('map')
                            ->will($this->throwException(new Exception("exception")));

        $this->expectException(Exception::class);

        $this->categoriaService->addCategoria(new CategoriaDTO("nombre",true,new Datetime(),publicId:uniqid()));
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

        $this->categoriaService->updateCategoria(new CategoriaDTO($categoriaToAdd->nombre,true,new Datetime(),publicId:$categoriaToAdd->publicId));

    }

    public function test_updateCategoria_Fail_ThrowException(){

        $this->categoriaMapper->expects($this->once())
                            ->method('map')
                            ->will($this->throwException(new Exception("exception")));

        $this->expectException(Exception::class);

        $this->categoriaService->updateCategoria(new CategoriaDTO("nombre",true,new Datetime(),publicId:uniqid()));
    }


    public function test_deleteCategoria_Success(){

        $publicId=uniqid();

        $this->categoriaRepositoryMock->expects($this->once())
        ->method('delete')
        ->with($this->equalTo($publicId));

        $this->categoriaService->deleteCategoria($publicId);
    }

    public function test_deleteCategoria_Fail_ExceptionThrown(){

        $publicId=uniqid();

        $this->categoriaRepositoryMock->expects($this->once())
        ->method('delete')
        ->will($this->throwException(new Exception("exception")));

        $this->expectException(Exception::class);

        $this->categoriaService->deleteCategoria($publicId);
    }

    public function test_ShouldAddSubCategoria_Success(){

        $this->categoriaMapper->expects($this->once())
                            ->method('map')
                            ->willReturn(new Categoria());

        $this->categoriaRepositoryMock->expects($this->once())->method('addSubCategoria');

        $this->categoriaService->addSubCategoria(uniqid(),new CategoriaDTO("nombre"));
    }

    public function test_ShouldAddSubCategorias_Success(){

        $this->categoriaMapper->expects($this->once())
                            ->method('map')
                            ->willReturn(new Categoria());

        $this->categoriaRepositoryMock->expects($this->once())->method('addSubCategorias');

        $this->categoriaService->addSubCategorias(uniqid(),[new CategoriaDTO("nombre")]);
    }

    public function test_ShouldgetSubCategorias_Succcess_NoSubChilds(){

        $this->categoriaRepositoryMock->expects($this->once())
                                        ->method('getSubCategoria')
                                        ->willReturn([new stdClass(),new stdClass()])
                                        ;
        $this->categoriaRepositoryMock->expects($this->atLeastOnce())
                                        ->method('hasSubCategorias')
                                        ->willReturn(false)
                                        ;
                                        
        $this->categoriaMapper->expects($this->atLeastOnce())
        ->method('reverse')
        ->willReturn($this->returnCallback(function()
            {
                $obj=new CategoriaDTO("nombre");
                $obj->publicId=uniqid();
                return $obj;
            }
        ));

        $subcategorias=$this->categoriaService->getSubCategorias(uniqid());

        $this->assertEquals(2,count($subcategorias));

    }

    public function test_ShouldgetSubCategorias_Succcess_SubChilds(){

        $parentId=uniqid();

        $categoria1=new Categoria();
        $categoria1->publicId=uniqid();
        $categoria1->nombre="categoria1";

        $categoria2=new Categoria();
        $categoria2->publicId=uniqid();
        $categoria2->nombre="categoria2";

        $childCategoria1= new CategoriaDTO("categoriahijo1");
        $childCategoria1->publicId=uniqid();

        $this->categoriaRepositoryMock->expects($this->atLeastOnce())
                                        ->method('getSubCategoria')
                                        ->willReturn($this->returnCallback(function($item) use ($parentId,$categoria1,$categoria2,$childCategoria1){
                                            if($item==$parentId) return [$categoria1, $categoria2];
                                            if($item==$categoria1->publicId) return [$childCategoria1];
                                            return [];
                                        }))
                                        ;
        $this->categoriaRepositoryMock->expects($this->atLeastOnce())
                                        ->method('hasSubCategorias')
                                        ->willReturn(true)
                                        ;
                                        
        $this->categoriaMapper->expects($this->atLeastOnce())
        ->method('reverse')
        ->willReturn($this->returnCallback(function()
            {
                $obj=new CategoriaDTO("nombre");
                $obj->publicId=uniqid();
                return $obj;
            }
        ));

        $subcategorias=$this->categoriaService->getSubCategorias($parentId,true);
        $this->assertEquals(2,count($subcategorias));
    }

}