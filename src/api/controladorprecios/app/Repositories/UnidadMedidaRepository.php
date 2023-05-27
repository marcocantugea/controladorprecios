<?php

namespace App\Repositories;

use App\Contractors\Data\IRepository;
use App\Contractors\Models\UnidadMedida;
use DateTime;
use Exception;
use Illuminate\Database\MySqlConnection;

class UnidadMedidaRepository  implements IRepository
{

    private MySqlConnection $db;

    public function __construct(MySqlConnection $db) {
        $this->db = $db;
    }

    public function add($model){
        if(!$model instanceof UnidadMedida ) throw new Exception("invalid model");
        $this->db->table('unidadesmedidas')->insert(
            [
                'publicId'=>uniqid(),
                'codigo'=>$model->codigo,
                'unidadMedida'=>$model->unidadDeMedida,
                'activo'=>true
            ]
        );
    }

    public function update($model)
    {
        if(!$model instanceof UnidadMedida ) throw new Exception("invalid model");
        if(empty($model->publicId)) throw new Exception('invalid id to update');
        $this->db->table('unidadesmedidas')->where('publicId',$model->publicId)->update(
            [
                'codigo'=>$model->codigo,
                'unidadMedida'=>$model->unidadDeMedida
            ]
        );
    }

    public function getById($id)
    {
        if(empty($id)) throw new Exception("invalid product id", 1);
        return $this->db->table('unidadesmedidas')
        ->where('publicId',$id)
        ->select([
            'publicId',
            'codigo',
            'unidadMedida',
            'activo',
            'created_at',
            'updated_at',
            'fecha_eliminado'
        ]
        )->first();
    }

    public function delete($id)
    {
        if(empty($id)) throw new Exception("invalid product id", 1);
        $this->db->table('unidadesmedidas')->where('publicId',$id)->update(
            [
                'activo'=>false,
                'fecha_eliminado'=>new DateTime('now')
            ]
        );
    }
}
