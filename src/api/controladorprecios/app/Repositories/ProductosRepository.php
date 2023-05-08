<?php

namespace App\Repositories;

use App\Contractors\Repositories\IProductosRepository;
use App\Contractors\Models\Producto;
use DateTime;
use Illuminate\Database\MySqlConnection;
use Exception;

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
}
