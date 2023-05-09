<?php

namespace Tests\UnitTests;

use App\Contractors\Models\Producto;
use App\Repositories\ProductosRepository;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Database\Connection;
use Illuminate\Database\Connectors\ConnectionFactory;
use DateTime;
use Faker\Core\Uuid;

use function PHPUnit\Framework\isNull;

class ProductosRepositoryTests extends TestCase
{
    // /** @var Productosrepository */
     protected Productosrepository $productosrepository;
     protected $db;

     protected function setUp(): void
     {
        parent::setUp();
        $this->db=$this->app->make('db')->connection();
        $this->productosrepository = new Productosrepository($this->db);
        
        
     }

     protected function setDown():void{

     }
    
    /**
     * Add new producto to table
     *
     * @return void
     */
    public function test_ShouldAddProductInTable()
    {
        $model= new Producto(); 
        $model->nombre="productoPrueba";
        $model->descripcion="descripcion prueba";
        $model->codigo="codigo";
        $model->sku="sku";
        $model->upc="upc";
        $model->ean="ean";

        $this->productosrepository->add($model);

        $producto=$this->db->table('productos')->where('nombre',$model->nombre)->get()[0];
        $this->assertTrue(!empty($producto));
        $this->assertEquals($model->descripcion,$producto->descripcion);
        $this->assertLessThan(new DateTime('now'),new Datetime($producto->created_at));

        //clean data
        $this->db->table('productos')->where('nombre',$model->nombre)->delete();
    }

    public function test_ShouldUpdateProductInTable(){
        
        $model= new Producto(); 
        $model->nombre="productoPrueba";
        $model->descripcion="descripcion prueba";
        $model->codigo="codigo";
        $model->sku="sku";
        $model->upc="upc";
        $model->ean="ean";

        $this->db->table('productos')->insert(
            [
                'nombre'=>$model->nombre,
                'descripcion'=>$model->descripcion,
                'codigo'=>$model->codigo,
                'sku'=>$model->sku,
                'upc'=>$model->upc,
                'ean'=>$model->ean
            ]
        );

        $productoFound=$this->db->table('productos')->where('nombre',$model->nombre)->get()[0];

        $updateModel=new Producto();
        $updateModel->publicId=$productoFound->publicId;
        $updateModel->nombre="productoPruebaupdated";
        $updateModel->descripcion="descripcion prueba updated";
        $updateModel->codigo="codigo1";
        $updateModel->sku="sku1";
        $updateModel->upc="upc1";
        $updateModel->ean="ean1";

        $this->productosrepository->update($updateModel);
        
        $productUpdated= $this->db->table('productos')->where('publicId',$updateModel->publicId)->get()[0];

        $this->assertTrue(!empty($productUpdated));
        $this->assertEquals($updateModel->descripcion,$productUpdated->descripcion);
        $this->assertLessThan(new DateTime('now'),new Datetime($productUpdated->updated_at));

        //clean data
        $this->db->table('productos')->where('publicId',$updateModel->publicId)->delete();
    }


    public function test_ShouldDeleteProductInTable(){
        
        $model= new Producto(); 
        $model->nombre="productoPruebafecha";
        $model->descripcion="descripcion prueba";
        $model->codigo="codigo";
        $model->sku="sku";
        $model->upc="upc";
        $model->ean="ean";

        $this->db->table('productos')->insert(
            [
                'nombre'=>$model->nombre,
                'descripcion'=>$model->descripcion,
                'codigo'=>$model->codigo,
                'sku'=>$model->sku,
                'upc'=>$model->upc,
                'ean'=>$model->ean
            ]
        );

        $productoFound=$this->db->table('productos')->where('nombre',$model->nombre)->get()[0];

        $this->productosrepository->delete($productoFound->publicId);
        
        $productUpdated= $this->db->table('productos')->where('publicId',$productoFound->publicId)->get()[0];

        $this->assertTrue(!empty($productUpdated));
        $this->assertFalse(boolval($productUpdated->activo));
        $this->assertInstanceOf('DateTime',new DateTime($productUpdated->fecha_eliminado));
        $this->assertLessThan(new DateTime('now'),new DateTime($productUpdated->fecha_eliminado));

        //clean data
        $this->db->table('productos')->where('publicId',$productUpdated->publicId)->delete();
    }

    public function test_ShoulGetProductById(){

        $model= new Producto(); 
        $model->nombre="productoPruebafecha";
        $model->descripcion="descripcion prueba";
        $model->codigo="codigo";
        $model->sku="sku";
        $model->upc="upc";
        $model->ean="ean";

        $this->db->table('productos')->insert(
            [
                'nombre'=>$model->nombre,
                'descripcion'=>$model->descripcion,
                'codigo'=>$model->codigo,
                'sku'=>$model->sku,
                'upc'=>$model->upc,
                'ean'=>$model->ean
            ]
        );

        $productoFound=$this->db->table('productos')->where('nombre',$model->nombre)->get()[0];

        $producto= $this->productosrepository->getById($productoFound->publicId)[0];

        $this->assertTrue(!empty($producto));
        $this->assertEquals($model->descripcion,$producto->descripcion);
    }

    public function test_ShouldGetProductos_All(){

        $productos= $this->productosrepository->getProductos([]);

        $this->assertGreaterThan(1,count($productos));
    }

    public function test_ShouldGetProductos_filter_NoOperator(){

        $model= new Producto(); 
        $model->nombre="productoPruebafecha";
        $model->descripcion="descripcion prueba";
        $model->codigo="998899";
        $model->sku="sku";
        $model->upc="upc";
        $model->ean="ean";

        $this->db->table('productos')->insert(
            [
                'nombre'=>$model->nombre,
                'descripcion'=>$model->descripcion,
                'codigo'=>$model->codigo,
                'sku'=>$model->sku,
                'upc'=>$model->upc,
                'ean'=>$model->ean
            ]
        );

        $filter=[
            "codigo"=>[$model->codigo,null]
        ];

        $productos= $this->productosrepository->getProductos($filter);

        $this->assertEquals($model->codigo,$productos[0]->codigo);
        $this->deleteProductAdded($model->codigo);
    }

    public function test_ShouldGetProductos_filter_Operator(){

        $model= new Producto(); 
        $model->nombre="productoPruebafecha";
        $model->descripcion="descripcion prueba";
        $model->codigo="998899";
        $model->sku="sku";
        $model->upc="upc";
        $model->ean="ean";

        $this->db->table('productos')->insert(
            [
                'nombre'=>$model->nombre,
                'descripcion'=>$model->descripcion,
                'codigo'=>$model->codigo,
                'sku'=>$model->sku,
                'upc'=>$model->upc,
                'ean'=>$model->ean
            ]
        );

        $filter=[
            "codigo"=>['%998%',"like"]
        ];

        $productos= $this->productosrepository->getProductos($filter);

        $this->assertEquals($model->codigo,$productos[0]->codigo);
        $this->deleteProductAdded($model->codigo);
    }

    public function test_ShouldUpdateProductoPropertySelected(){
        $model= new Producto(); 
        $model->publicId= uniqid();
        $model->nombre="productoPruebafecha";
        $model->descripcion="descripcion prueba";
        $model->codigo="998800";
        $model->sku="sku";
        $model->upc="upc";
        $model->ean="ean";

        $this->db->table('productos')->insert(
            [
                'publicId'=>$model->publicId,
                'nombre'=>$model->nombre,
                'descripcion'=>$model->descripcion,
                'codigo'=>$model->codigo,
                'sku'=>$model->sku,
                'upc'=>$model->upc,
                'ean'=>$model->ean
            ]
        );

        $updateProperty=[
            "sku"=>"239403",
            "upc"=>"39304"
        ];

        $this->productosrepository->updateProductoByProperty($model->publicId,$updateProperty);

        $productoUpdated=$this->db->table('productos')->where('codigo',$model->codigo)->get()[0];

        $this->assertEquals($productoUpdated->sku,"239403");
        $this->assertEquals($productoUpdated->upc,"39304");
        $this->deleteProductAdded($model->codigo);
    }

    private function deleteProductAdded($productoCode){
        $this->db->table('productos')->where('codigo',$productoCode)->delete();
    }
}
