<?php

namespace Tests\UnitTests;

use App\Contractors\Models\Categoria;
use App\Contractors\Models\Producto;
use App\Repositories\CategoriaRepository;
use App\Repositories\ProductosRepository;
use Tests\TestCase;
use DateTime;

class CategoriasRepositoryTests extends TestCase
{
    // /** @var CategoriaRepository */
     protected CategoriaRepository $categoriaRepository;
     protected $db;

     protected function setUp(): void
     {
        parent::setUp();
        $this->db=$this->app->make('db')->connection();
        $this->categoriaRepository = new CategoriaRepository($this->db);
        
        
     }

     protected function setDown():void{

     }
    
    public function test_ShouldAddCategoriaInTable()
    {
        $model= new Categoria(); 
        $model->nombre="categoriaDePrueba";

        $this->categoriaRepository->add($model);

        $categoria=$this->db->table('categorias')->where('nombre',$model->nombre)->get()[0];
        $this->assertTrue(!empty($categoria));
        $this->assertEquals($model->nombre,$categoria->nombre);
        $this->assertLessThan(new DateTime('now'),new Datetime($categoria->created_at));

        //clean data
        $this->db->table('categorias')->where('nombre',$model->nombre)->delete();
    }

    public function test_ShouldUpdateCategoriaInTable(){
        
        $model= new Categoria(); 
        $model->publicId=uniqid();
        $model->nombre="categoriaDePrueba";

        $this->db->table('categorias')->insert(
            [
                'publicID'=>$model->publicId,
                'nombre'=>$model->nombre,
                'activo'=>true,
                'created_at'=>new DateTime('now')
            ]
        );

        $categoriaFound=$this->db->table('categorias')->where('nombre',$model->nombre)->get()[0];

        $updateModel=new Categoria();
        $updateModel->publicId=$categoriaFound->publicId;
        $updateModel->nombre="CategoriaPruebaupdated";

        $this->categoriaRepository->update($updateModel);
        
        $Updated= $this->db->table('categorias')->where('publicId',$updateModel->publicId)->get()[0];

        $this->assertTrue(!empty($Updated));
        $this->assertEquals($updateModel->nombre,$Updated->nombre);
        $this->assertLessThan(new DateTime('now'),new Datetime($Updated->updated_at));

        //clean data
        $this->db->table('categorias')->where('publicId',$updateModel->publicId)->delete();
    }


    public function test_ShouldDeleteCategoriaInTable(){
        
           
        $model= new Categoria(); 
        $model->publicId=uniqid();
        $model->nombre="categoriaDePrueba";

        $this->db->table('categorias')->insert(
            [
                'publicID'=>$model->publicId,
                'nombre'=>$model->nombre,
                'activo'=>true,
                'created_at'=>new DateTime('now')
            ]
        );

        $categoriaFound=$this->db->table('categorias')->where('publicId',$model->publicId)->get()[0];

        $this->categoriaRepository->delete($categoriaFound->publicId);
        
        $Updated= $this->db->table('categorias')->where('publicId',$model->publicId)->get()[0];

        $this->assertTrue(!empty($Updated));
        $this->assertFalse(boolval($Updated->activo));
        $this->assertInstanceOf('DateTime',new DateTime($Updated->fecha_eliminado));
        $this->assertLessThan(new DateTime('now'),new DateTime($Updated->fecha_eliminado));

        //clean data
        $this->db->table('categorias')->where('publicId',$Updated->publicId)->delete();
    }

    public function test_ShoulGetCategoriaById(){

        $model= new Categoria(); 
        $model->publicId=uniqid();
        $model->nombre="categoriaDePrueba";

        $this->db->table('categorias')->insert(
            [
                'publicID'=>$model->publicId,
                'nombre'=>$model->nombre,
                'activo'=>true,
                'created_at'=>new DateTime('now')
            ]
        );

        $categoria= $this->categoriaRepository->getById($model->publicId);

        $this->assertTrue(!empty($categoria));
        $this->assertEquals($model->nombre,$categoria->nombre);

        //clean data
        $this->db->table('categorias')->where('publicId',$model->publicId)->delete();
    }

    public function test_ShouldaddSubCategoria(){
        
        $model= new Categoria(); 
        $model->publicId=uniqid();
        $model->nombre="categoriaPadre";

        $this->db->table('categorias')->insert(
            [
                'publicID'=>$model->publicId,
                'nombre'=>$model->nombre,
                'activo'=>true,
                'created_at'=>new DateTime('now')
            ]
        );

        $subCategoria= new Categoria();
        $subCategoria->nombre="categoriaHijo";

        $this->categoriaRepository->addSubCategoria($model->publicId,$subCategoria);

        $subCategorias= $this->db->table('subcategorias')
                                    ->join('categorias as parent','subcategorias.categoriaId','parent.Id')
                                    ->join('categorias as child','subcategorias.subcategoriaId','child.Id')
                                    ->where('parent.publicId',$model->publicId)
                                    ->select('parent.publicId as parentId','child.publicId as childId','child.nombre')
                                    ->get();

        $this->assertEquals(1,count($subCategorias));
        $this->assertEquals($model->publicId,$subCategorias[0]->parentId);
        $this->assertEquals($subCategoria->nombre,$subCategorias[0]->nombre);

        $this->db->table('subcategorias')->delete();
        $this->db->table('categorias')->where('publicId',$subCategorias[0]->parentId)->delete();
        $this->db->table('categorias')->where('publicId',$subCategorias[0]->childId)->delete();
    }

    public function test_ShouldAddSubCategorias(){
        
        $model= new Categoria(); 
        $model->publicId=uniqid();
        $model->nombre="categoriaPadre1";

        $this->db->table('categorias')->insert(
            [
                'publicID'=>$model->publicId,
                'nombre'=>$model->nombre,
                'activo'=>true,
                'created_at'=>new DateTime('now')
            ]
        );

        $subCategoria= new Categoria();
        $subCategoria->nombre="categoriaHijo";

        $subCategoria1=new Categoria();
        $subCategoria1->nombre='categoriaHijo1';

        $subCategoria2=new Categoria();
        $subCategoria2->nombre='categoriaHijo2';

        $subcategorias=[$subCategoria,$subCategoria1,$subCategoria2];

        $this->categoriaRepository->addSubCategorias($model->publicId,$subcategorias);

        $subCategoriasFound= $this->db->table('subcategorias')
        ->join('categorias as parent','subcategorias.categoriaId','parent.Id')
        ->join('categorias as child','subcategorias.subcategoriaId','child.Id')
        ->where('parent.publicId',$model->publicId)
        ->select('parent.publicId as parentId','child.publicId as childId','child.nombre')
        ->get();

        $this->assertGreaterThan(1,count($subCategoriasFound));
        $this->assertEquals($model->publicId,$subCategoriasFound[0]->parentId);
        $this->assertEquals($subCategoria->nombre,$subCategoriasFound[0]->nombre);

        $this->db->table('subcategorias')->delete();
        $this->db->table('categorias')->where('nombre',$model->nombre)->delete();
    }


    public function test_ShouldGetSubCategoria(){
        $model= new Categoria(); 
        $model->publicId=uniqid();
        $model->nombre="categoriaPadre283";

        $this->db->table('categorias')->insert(
            [
                'publicID'=>$model->publicId,
                'nombre'=>$model->nombre,
                'activo'=>true,
                'created_at'=>new DateTime('now')
            ]
        );

        $subCategoria= new Categoria();
        $subCategoria->nombre="categoriaHijo1-283";

        $subCategoria1=new Categoria();
        $subCategoria1->nombre='categoriaHijo2-283';

        $subCategoria2=new Categoria();
        $subCategoria2->nombre='categoriaHijo3-283';

        $subcategorias=[$subCategoria,$subCategoria1,$subCategoria2];

        $this->categoriaRepository->addSubCategorias($model->publicId,$subcategorias);

        $subcategoriasFound= $this->categoriaRepository->getSubCategoria($model->publicId);
        $this->assertGreaterThanOrEqual(3,count($subcategoriasFound));
        foreach ($subcategoriasFound as $value) {
            $this->assertTrue(str_contains($value->nombre,'-283'));
        }

        $this->db->table('subcategorias')->delete();
        $this->db->table('categorias')->where('publicId',$model->publicId)->delete();
    }


    public function test_ShouldhasSubCategorias(){
        $model= new Categoria(); 
        $model->publicId=uniqid();
        $model->nombre="categoriaPadre284";

        $this->db->table('categorias')->insert(
            [
                'publicID'=>$model->publicId,
                'nombre'=>$model->nombre,
                'activo'=>true,
                'created_at'=>new DateTime('now')
            ]
        );

        $subCategoria= new Categoria();
        $subCategoria->nombre="categoriaHijo1-284";

        $subCategoria1=new Categoria();
        $subCategoria1->nombre='categoriaHijo2-284';

        $subCategoria2=new Categoria();
        $subCategoria2->nombre='categoriaHijo3-284';

        $subcategorias=[$subCategoria,$subCategoria1,$subCategoria2];

        $this->categoriaRepository->addSubCategorias($model->publicId,$subcategorias);

        $hasSubcategorias=$this->categoriaRepository->hasSubCategorias($model->publicId);

        $this->assertTrue($hasSubcategorias);

        $this->db->table('subcategorias')->delete();
        $this->db->table('categorias')->where('publicId',$model->publicId)->delete();
    }


    public function test_ShouldhasSubCategorias_noSubCategorias(){
        $model= new Categoria(); 
        $model->publicId=uniqid();
        $model->nombre="categoriaPadre285";

        $this->db->table('categorias')->insert(
            [
                'publicID'=>$model->publicId,
                'nombre'=>$model->nombre,
                'activo'=>true,
                'created_at'=>new DateTime('now')
            ]
        );

        $hasSubcategorias=$this->categoriaRepository->hasSubCategorias($model->publicId);

        $this->assertFalse($hasSubcategorias);

        $this->db->table('categorias')->where('publicId',$model->publicId)->delete();
    }

}
