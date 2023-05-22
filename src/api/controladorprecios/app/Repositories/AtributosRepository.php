<?php 

namespace App\Repositories;

use App\Contractors\Models\Atributo;
use App\Contractors\Repositories\IAtributoRepository;
use Illuminate\Database\MySqlConnection;

class AtributosRepository  implements IAtributoRepository
{
    private MySqlConnection $db;

    public function __construct(MySqlConnection $db) {
        $this->db = $db;
    }

    public function add($model)
    {
        if(!$model instanceof Atributo) throw new \Exception("model is not instance of atributo", 1);
        $this->db->table('atributos')->insert(
            [
                'publicId'=> uniqid(),
                'atributo'=>$model->atributo,
                'created_at'=>new \DateTime('now')
            ]
        );
    }

    public function delete($id)
    {
        if(empty($id)) throw new \Exception("invalid atributo id", 1);
        $this->db->table('atributos')->where('publicId',$id)
        ->update([
            'activo'=>false,
            'fecha_eliminado'=> new \DateTime('now')
        ]);
    }

    public function update($model)
    {
        if(!$model instanceof Atributo) throw new \Exception("model is not instance of Atributo", 1);
        if(empty($model->publicId)) throw new \Exception("invalid categoria id", 1);
        $this->db->table('atributos')->where('publicId',$model->publicId)
        ->update([
            'atributo'=>$model->atributo,
            'updated_at'=>new \DateTime('now')
        ]);
    }

    public function getById($id)
    {
        return $this->db->table('atributos')
                            ->where('publicId',$id)
                            ->first([
                                'publicId',
                                'atributo',
                                'activo',
                                'created_at',
                                'updated_at',
                                'fecha_eliminado',
                                'esSubatributo'
                            ]);
    }

    public function searchAtributos(array $searchParams): array
    {
        $atributosQuery=$this->db->table('atributos');

        $likeFiels=[
            'atributo'
        ];

        foreach ($searchParams as $key => $value) {
            $operator='=';
            if(in_array($key,$likeFiels)) $operator='like';
            $atributosQuery=$atributosQuery->where($key,$operator,$value);
        }

        return $atributosQuery->select([
            'publicId',
            'atributo',
            'activo',
            'created_at',
            'updated_at',
            'fecha_eliminado',
            'esSubatributo'
        ])->get()->toArray();
    }
}
