<?php

namespace App\Repositories;

use App\Contractors\Repositories\IProductosRepository;
use App\Contractors\Models\Producto;
use App\DTOs\CategoriaDTO;
use DateTime;
use Illuminate\Database\MySqlConnection;
use Exception;
use Hamcrest\Arrays\IsArray;

class ProductosRepository implements IProductosRepository
{
    private MySqlConnection $db;

    public function __construct(MySqlConnection $db) {
        $this->db = $db;
    }

    public function add($model){
        if(!$model instanceof Producto) throw new Exception("model is not instance of Producto", 1);
        $this->db->table('productos')->insert(
            [
                'publicId'=> uniqid(),
                'nombre'=>$model->nombre,
                'descripcion'=>$model->descripcion,
                'codigo'=>$model->codigo,
                'sku'=>$model->sku,
                'upc'=>$model->upc,
                'ean'=>$model->ean,
                'created_at'=>new DateTime('now')
            ]
        );
    }

    public function update($model){
        if(!$model instanceof Producto) throw new Exception("model is not instance of Producto", 1);
        if(empty($model->publicId)) throw new Exception("invalid product id", 1);
        $this->db->table('productos')->where('publicId',$model->publicId)
        ->update([
            'nombre'=>$model->nombre,
            'descripcion'=>$model->descripcion,
            'codigo'=>$model->codigo,
            'sku'=>$model->sku,
            'upc'=>$model->upc,
            'ean'=>$model->ean,
            'updated_at'=>new DateTime('now')
        ]);
    }

    public function delete($id){
        if(empty($id)) throw new Exception("invalid product id", 1);
        $this->db->table('productos')->where('publicId',$id)
        ->update([
            'activo'=>false,
            'fecha_eliminado'=> new DateTime('now')
        ]);
    }

    public function getById($id){
        if(empty($id)) throw new Exception("invalid product id", 1);
        return $this->db->table('productos')
        ->where('publicId',$id)
        ->select(
            'publicId',
            'nombre',
            'descripcion',
            'codigo',
            'sku',
            'upc',
            'ean',
            'activo',
            'created_at',
            'updated_at',
            'fecha_eliminado'
        )->get();
    }

    function getProductos(array $searchParams,int $limit=500,int $offset=0){
        
        $query= $this->db->table('productos');
        foreach ($searchParams as $key => [$value,$operator]) {
            $query->where($key,empty($operator) ? '=' : $operator,$value);
        }

        return $query->select(
            'publicId',
            'nombre',
            'descripcion',
            'codigo',
            'sku',
            'upc',
            'ean',
            'activo',
            'created_at',
            'updated_at',
            'fecha_eliminado'
        )->skip($offset)->take(500)->get();

    }

    public function updateProductoByProperty(string $id,array $fieldValue){
        $this->db->table('productos')->where('publicId',$id)->update($fieldValue);
    }

    public function assignCategoryToProduct(string $id, array $categoriaDto)
    {
        //validamos que los objetos del array sean CategoriaDTO
        foreach ($categoriaDto as $value) if(!$value instanceof CategoriaDTO) throw new Exception("item in the array is not a categoria dto");

        //obtenemos el id del productos y los ids de las categorias.
        $idProducto= $this->db->table('productos')->where('publicId',$id)->first('id')->id;
        //obtenemos los ids de las categorias
        $categoriasPublicIds= array_map(function($item){
            return $item->publicId;
        },$categoriaDto);

        $categoriesIds=$this->db->table('categorias')->whereIn('publicId',$categoriasPublicIds)->get('id');

        $insertValues=[];

        foreach ($categoriesIds as $value) {
            $insertValues[]=["productoId"=>$idProducto,"categoriaId"=>$value->id];
        }

        //insertamos valores en la tabla
        $this->db->table('productoscategorias')->insert($insertValues);

    }

    public function getCategoriasOfProducto($id){

        return $this->db->table('productoscategorias')
                         ->join('productos','productoscategorias.productoId','productos.Id')
                         ->join('categorias','productoscategorias.categoriaId','categorias.Id')
                         ->Where('productos.publicId',$id)
                         ->select(
                            'categorias.publicId',
                            'categorias.nombre',
                            'categorias.activo',
                            'categorias.created_at',
                            'categorias.updated_at',
                            'categorias.fecha_eliminado',
                            'categorias.esSubcategoria',
                         )->get();
    }
}
