<?php 

namespace Tests\UnitTests;

use App\Contractors\Models\Atributo;
use App\DTOs\AtributoDTO;
use App\Mappers\AtributoMapper;
use Tests\TestCase;
use \DateTime;
use PHPUnit\TextUI\CliArguments\Mapper;

class AtributoMapperTests extends TestCase
{

    private AtributoMapper $mapper;

    public function SetUp():void{

        parent::setUp();
        $this->mapper=new AtributoMapper();
    }

    public function test_ShouldMapAtributo(){

        $atributoDTO= new AtributoDTO("atributo1");
        $atributo= $this->mapper->map($atributoDTO);
        $this->assertInstanceOf(Atributo::class,$atributo);

        $this->assertEquals($atributoDTO->atributo,$atributo->atributo);
    }

    public function test_ShouldMapAllPropertiesAtributo(){
        $atributoDTO= new AtributoDTO("atributo1",uniqid(),true,new DateTime('now'),new DateTime('now'),new DateTime('now'),true);
        $atributo= $this->mapper->map($atributoDTO);
        $this->assertInstanceOf(Atributo::class,$atributo);
        $this->assertNotEmpty($atributo->publicId);
        $this->assertTrue($atributo->activo);
        $this->assertLessThanOrEqual(new DateTime('now'),$atributo->created_at);
        $this->assertLessThanOrEqual(new DateTime('now'),$atributo->updated_at);
        $this->assertLessThanOrEqual(new DateTime('now'),$atributo->fecha_eliminado);
        $this->assertTrue($atributo->esSubatributo);
    }

    public function test_ShouldMapAtributoDTO(){
        $atributo = new Atributo("atributo1");
        $atributoDTO= $this->mapper->reverse($atributo);
        $this->assertInstanceOf(AtributoDTO::class,$atributoDTO);
        $this->assertEquals($atributoDTO->atributo,$atributo->atributo);
    }

    public function test_ShouldMapAllPropertiesAtributoDTO(){
        $atributo=new Atributo("atribuito1",uniqid(),true,new DateTime('now'),new DateTime('now'),new DateTime('now'),true);
        $atributoDTO= $this->mapper->reverse($atributo);
        $this->assertInstanceOf(AtributoDTO::class,$atributoDTO);
        $this->assertEquals($atributoDTO->atributo,$atributo->atributo);
        $this->assertTrue($atributoDTO->activo);
        $this->assertLessThanOrEqual(new DateTime('now'),$atributoDTO->created_at);
        $this->assertLessThanOrEqual(new DateTime('now'),$atributoDTO->updated_at);
        $this->assertLessThanOrEqual(new DateTime('now'),$atributoDTO->fecha_eliminado);
        $this->assertTrue($atributoDTO->esSubatributo);
    }

    public function test_shouldMapStdObjectToAtributo(){
        $atributoDTO= new AtributoDTO("atributo1",uniqid(),true,'2023-01-01 00:00:00','2023-01-01 00:00:00','2023-01-01 00:00:00',true);
        $stdObj= json_decode(json_encode($atributoDTO));
        $atributo=$this->mapper->map($stdObj);
        $this->assertInstanceOf(Atributo::class,$atributo);
        $this->assertNotEmpty($atributo->publicId);
        $this->assertTrue($atributo->activo);
        $this->assertLessThanOrEqual(new DateTime('now'),$atributo->created_at);
        $this->assertLessThanOrEqual(new DateTime('now'),$atributo->updated_at);
        $this->assertLessThanOrEqual(new DateTime('now'),$atributo->fecha_eliminado);
        $this->assertTrue($atributo->esSubatributo);
    }

    public function test_ShouldMapStdObjToAtributoDTO(){
        $atributo=new Atributo("atribuito1",uniqid(),true,new DateTime('now'),new DateTime('now'),new DateTime('now'),true);
        $stdObj= json_decode(json_encode($atributo));
        $atributoDTO= $this->mapper->reverse($stdObj);
        $this->assertInstanceOf(AtributoDTO::class,$atributoDTO);
        $this->assertEquals($atributoDTO->atributo,$atributo->atributo);
        $this->assertTrue($atributoDTO->activo);
        $this->assertLessThanOrEqual(new DateTime('now'),$atributoDTO->created_at);
        $this->assertLessThanOrEqual(new DateTime('now'),$atributoDTO->updated_at);
        $this->assertLessThanOrEqual(new DateTime('now'),$atributoDTO->fecha_eliminado);
        $this->assertTrue($atributoDTO->esSubatributo);
    }

}