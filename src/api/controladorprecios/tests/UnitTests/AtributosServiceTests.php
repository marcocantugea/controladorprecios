<?php

namespace Tests\UnitTests;

use App\Contractors\Models\Atributo;
use App\Contractors\Repositories\IAtributoRepository;
use App\Contractors\Services\IAtributosService;
use App\DTOs\AtributoDTO;
use App\Mappers\AtributoMapper;
use App\Repositories\AtributosRepository;
use App\Services\AtributosService;
use Tests\TestCase;

class AtributosServiceTests extends TestCase 
{
    private $atributosRepository;
    private $mapper;
    private AtributosService $service;

    protected function setUp(): void
    {
       parent::setUp();
       $this->atributosRepository= $this->createMock(AtributosRepository::class);
        
        $this->mapper= $this->createMock(AtributoMapper::class);
       
        $this->service= new AtributosService($this->atributosRepository,$this->mapper);
       
    }

    public function test_ShouldAddAtributo(){
        $this->atributosRepository->expects($this->atLeastOnce())
                                    ->method('add');
        $this->mapper->expects($this->atLeastOnce())
                        ->method('map')
                        ->willReturn(new Atributo("test"));
        
        $this->service->addAtributo(new Atributo("test"));
    }


    public function test_ShouldUpdateAtributo(){
        $this->atributosRepository->expects($this->atLeastOnce())
                                    ->method('update');
        $this->mapper->expects($this->atLeastOnce())
                        ->method('map')
                        ->willReturn(new Atributo("test"));
        
        $this->service->updateAtributo(new Atributo("test"));
    }

    public function test_ShouldDeleteAtributo(){
        $this->atributosRepository->expects($this->once())
                                    ->method('delete');

        $this->service->deleteAtributo(uniqid());
    }

    public function test_ShouldGetAtributoById(){
        
        $this->atributosRepository->expects($this->once())
                                    ->method('getById')
                                    ->willReturn(new AtributoDTO("test1"));
        
        $this->mapper->expects($this->atLeastOnce())
                                    ->method('map')
                                    ->willReturn(new Atributo("test1"));
        
        $atributo= $this->service->getAtributo(uniqid());

        $this->assertEquals("test1",$atributo->atributo);

    }

    public function test_ShouldGetAtributosBySearchParams(){

        $item1=new AtributoDTO("atributo1",uniqid());
        $item2=new AtributoDTO("atributo2",uniqid());
        $item3=new AtributoDTO("atributo3",uniqid());
        $item4=new AtributoDTO("atributo4",uniqid());
        $item5=new AtributoDTO("atributo5",uniqid());

        $items=[
            $item1,$item2,$item3,$item4,$item5
        ];

        $this->atributosRepository->expects($this->once())
                                    ->method('searchAtributos')
                                    ->willReturn($items);

        $this->mapper->expects($this->atLeastOnce())
            ->method('reverse')
            ->willReturn(new AtributoDTO("test",uniqid()));

        
        $itemsFound=$this->service->getAtributos(['atributo'=>'atributo']);
        $this->assertEquals(5,count($itemsFound));
        
    }
}
