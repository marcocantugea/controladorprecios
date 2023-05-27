<?php 

namespace Tests\UnitTests;

use App\Contractors\Data\IRepository;
use App\Contractors\IMapper;
use App\Contractors\Models\Marca;
use App\Contractors\Repositories\IMarcaRepository;
use App\DTOs\MarcaDTO;
use App\Services\MarcasService;
use Exception;
use Tests\TestCase;

class MarcasServiceTests extends TestCase{

    private IMarcaRepository $repositoryMock;
    private IMapper $mapperMock;
    private MarcasService $marcaService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repositoryMock= $this->createMock(IMarcaRepository::class);
        $this->mapperMock= $this->createMock(IMapper::class);

        $this->marcaService= new MarcasService($this->repositoryMock,$this->mapperMock);
    }

    public function test_ShouldAddMarca_Succes(){

        $this->mapperMock->expects($this->once())
                            ->method('map')
                            ->willReturn(new Marca("test"));
        
        $this->repositoryMock->expects($this->once())
                                ->method('add');


        $this->marcaService->addMarca(new MarcaDTO('test'));
    }

    public function test_ShouldAddMarca_Fail_ExceptionThrow(){

        $this->mapperMock->expects($this->once())
                            ->method('map')
                            ->willThrowException(new Exception('error'));
        
        $this->expectException(Exception::class);

        $this->marcaService->addMarca(new MarcaDTO('test'));
    }

    public function test_ShouldUpdateMarca_Succes(){

        $this->mapperMock->expects($this->once())
                            ->method('map')
                            ->willReturn(new Marca("test"));
        
        $this->repositoryMock->expects($this->once())
                                ->method('update');


        $this->marcaService->updateMarca(new MarcaDTO('test'));
    }

    public function test_ShouldUpdateMarca_Fail_ExceptionThrow(){

        $this->mapperMock->expects($this->once())
                            ->method('map')
                            ->willThrowException(new Exception('error'));
        
        $this->expectException(Exception::class);

        $this->marcaService->updateMarca(new MarcaDTO('test'));
    }

    public function test_ShouldDeleteMarca_Succes(){

        $this->repositoryMock->expects($this->once())
                                ->method('delete');


        $this->marcaService->deleteMarca(uniqid());
    }

    public function test_ShouldDeleteMarca_Fail_ExceptionThrow(){

        $this->repositoryMock->expects($this->once())
                                ->method('delete')
                                ->willThrowException(new Exception('error'));


        $this->expectException(Exception::class);

        $this->marcaService->deleteMarca(uniqid());
    }

    public function test_ShouldGetMarca_Succes(){

        $id=uniqid();

        $this->mapperMock->expects($this->once())
                            ->method('reverse')
                            ->willReturn(new MarcaDTO("test",publicId:$id));
        
        $this->repositoryMock->expects($this->once())
                                ->method('getById')
                                ->with($id)
                                ->willReturn(new Marca("test",publicId:$id))
                                ;


        $response=$this->marcaService->getMarca($id);

        $this->assertEquals($id,$response->publicId);
    }

    public function test_ShouldGetMarcas_Succes_noParameters(){

        $marca1= new Marca("marca1",1,uniqid());
        $marca2= new Marca("marca2",1,uniqid());
        $marca3= new Marca("marca3",1,uniqid());

        $items=[$marca1,$marca2,$marca3];

        $this->repositoryMock->expects($this->once())
                                ->method('getMarcas')
                                ->with([])
                                ->willReturn($items)
                                ;

        $this->mapperMock->expects($this->atLeastOnce())
                            ->method('reverse')
                            ->willReturn(new MarcaDTO('marca',uniqid(),true));

        $dtos= $this->marcaService->getMarcas([]);

        $this->assertEquals(3,count($dtos));
        foreach ($dtos as $value) {
            $this->assertInstanceOf(MarcaDTO::class,$value);
        }

    }
}