<?php

namespace App\Repositories;

use App\Contractors\Models\Categoria;
use App\Contractors\Repositories\ICategoriaRepository;
use Illuminate\Database\MySqlConnection;
use Exception;
use DateTime;

class CategoriaRepository implements ICategoriaRepository
{
    private MySqlConnection $db;

    public function __construct(MySqlConnection $db) {
        $this->db = $db;
    }

    public function add($model)
    {
        if(!$model instanceof Categoria) throw new Exception("model is not instance of categoria", 1);
        $this->db->table('categorias')->insert(
            [
                'publicId'=> uniqid(),
                'nombre'=>$model->nombre,
                'created_at'=>new DateTime('now')
            ]
        );
    }

    public function delete($id)
    {
        if(empty($id)) throw new Exception("invalid categoria id", 1);
        $this->db->table('categorias')->where('publicId',$id)
        ->update([
            'activo'=>false,
            'fecha_eliminado'=> new DateTime('now')
        ]);
    }

    public function getById($id)
    {
        if(empty($id)) throw new Exception("invalid categoria id", 1);
        return $this->db->table('categorias')
        ->where('publicId',$id)
        ->select(
            'publicId',
            'nombre',
            'activo',
            'created_at',
            'updated_at',
            'fecha_eliminado',
            'esSubcategoria'
        )->get()[0];
    }

    public function update($model)
    {
        if(!$model instanceof Categoria) throw new Exception("model is not instance of Categoria", 1);
        if(empty($model->publicId)) throw new Exception("invalid categoria id", 1);
        $this->db->table('categorias')->where('publicId',$model->publicId)
        ->update([
            'nombre'=>$model->nombre,
            'updated_at'=>new DateTime('now')
        ]);
    }

    public function searchCategory(string $nombre,bool $esSubcategoria=false){
        $query=$this->db->table('categorias')->where('esSubcategoria',$esSubcategoria);
        if(!empty($nombre)) $query->where('nombre','like',$nombre,true);
        $query->select(
                        'publicId',
                        'nombre',
                        'activo',
                        'created_at',
                        'updated_at',
                        'fecha_eliminado'
        );

        return $query->get();
    }

    public function addSubCategoria($id,Categoria $model)
    {
        if(!$model instanceof Categoria) throw new Exception("model is not instance of categoria", 1);
        $model->publicId=uniqid();
        $this->db->table('categorias')->insert(
            [
                'publicId'=> $model->publicId,
                'nombre'=>$model->nombre,
                'created_at'=>new DateTime('now'),
                'esSubcategoria'=>true
            ]
        );

        $idCategoria=  $this->db->table('categorias')->where('publicId',$id)->get('id')[0]->id;
        $idSubCategoria= $this->db->table('categorias')->where('publicId',$model->publicId)->get('id')[0]->id;

        $this->db->table('subcategorias')->insert(
            ['categoriaId'=>$idCategoria,'subcategoriaId'=>$idSubCategoria]
        );

    }
}
