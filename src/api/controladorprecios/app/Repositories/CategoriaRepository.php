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
            'fecha_eliminado'
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

    public function searchCategory(string $nombre){
        $query=$this->db->table('categorias');
        if(!empty($nombre)) $query->where('nombre','like',$nombre);
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
}
