<?php

namespace App\Repositories;

use App\Contractors\Models\Marca;
use App\Contractors\Repositories\IMarcaRepository;
use DateTime;
use Exception;
use Illuminate\Database\MySqlConnection;

class MarcasRepository implements IMarcaRepository{

    private MySqlConnection $db;

    public function __construct(MySqlConnection $db) {
        $this->db = $db;
    }

    public function add($model)
    {
        if(!$model instanceof Marca) throw new \Exception("model is not instance of marca", 1);
        $this->db->table('marcas')->insert(
            [
                'publicId'=> uniqid(),
                'marca'=>$model->marca,
                'created_at'=>new \DateTime('now'),
                'activo'=>true
            ]
        );
    }

    public function delete($id)
    {
        if(empty($id)) throw new Exception("invalid product id", 1);
        $this->db->table('marcas')->where('publicId',$id)->update([
            'activo'=>false,
            'fecha_eliminado'=>new DateTime('now')
        ]);
    }

    public function update($model)
    {
        if(!$model instanceof Marca) throw new \Exception("model is not instance of marca", 1);
        if(empty($model->publicId)) throw new Exception("invalid public id");

        $this->db->table('marcas')->where('publicId',$model->publicId)->update([
            'marca'=>$model->marca,
            'updated_at'=>new DateTime('now')
        ]);
    }

    public function getById($id)
    {
        if(empty($id)) throw new Exception("invalid product id", 1);
        return $this->db->table('marcas')
                        ->where('publicId',$id)
                        ->select([
                            'publicId',
                            'marca',
                            'activo',
                            'created_at',
                            'updated_at',
                            'fecha_eliminado'
                        ])
                        ->first();
    }

    public function getMarcas(array $serachParams) :array{
        $atributosQuery=$this->db->table('marcas');

        $likeFiels=[
            'marca'
        ];

        foreach ($serachParams as $key => $value) {
            $operator='=';
            if(in_array($key,$likeFiels)) $operator='like';
            $atributosQuery=$atributosQuery->where($key,$operator,$value);
        }

        return $atributosQuery->select([
            'publicId',
            'marca',
            'activo',
            'created_at',
            'updated_at',
            'fecha_eliminado'
        ])->get()->toArray();
    }

}