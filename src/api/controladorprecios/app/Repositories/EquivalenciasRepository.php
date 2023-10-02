<?php

namespace App\Repositories;

use App\Contractors\Models\Equivalencia;
use App\Contractors\Repositories\IEquivalenciasRepository;
use DateTime;
use Exception;
use Illuminate\Database\MySqlConnection;


class EquivalenciasRepository implements IEquivalenciasRepository
{
    private MySqlConnection $db;

    public function __construct(
        MySqlConnection $db
    ) {
        $this->db=$db;
    }

    public function add($model)
    {
        try {
            if(!$model instanceof Equivalencia) throw new Exception('invalid model');
            if(empty($model->productoId) || empty($model->productoIdEqu)) throw new Exception("missing product or equivalencia id");
            if($this->existProductEquivalencia($model->productoId,$model->productoIdEqu)) throw new Exception('producto equivalence already assigned');
            $this->db->table('equivalencias')->insert(
                [
                    'publicId'=>uniqid(),
                    'productoId'=>$model->productoId,
                    'productoIdEqu'=>$model->productoIdEqu,
                    'created_at'=>new DateTime()
                ]
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update($model)
    {
        throw new Exception('not implementation need it');
    }

    public function delete($id)
    {
        try {
            if(empty($id)) throw new Exception("invalid id");
            $this->db->table('equivalencias')
            ->where([
                'publicId'=>$id
            ])
            ->update([
                'fecha_eliminado'=>new DateTime()
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }    
    }

    public function getById($id)
    {
        return $this->db->table('equivalencias')
        ->leftJoin('productos as p1','equivalencias.productoId','p1.id')
        ->leftJoin('productos as p2','equivalencias.productoIdEqu','p2.id')
        ->where('equivalencias.publicId',$id)
        ->whereNull('fecha_eliminado')
        ->select([
            'equivalencias.id',
            'equivalencias.publicId',
            'equivalencias.productoId',
            'p1.publicId as productoPublicId',
            'p1.codigo as productoCodigo',
            'p1.nombre as productoNombre',
            'p1.descripcion as productoDescripcion',
            'p2.publicId as equivalenciaPublicId',
            'p2.codigo as equivalenciaCodigo',
            'p2.nombre as equivalenciaNombre',
            'p2.descripcion as equivalenciaDescripcion',
            'equivalencia.created_at',
            'equivalencia.fecha_eliminado'
        ])
        ->first();
    }

    public function existProductEquivalencia(int $productoId,int $productoIdEqu){
        return $this->db->table('equivalencias')
        ->where([
            'productoId'=>$productoId,
            'productoIdEqu'=>$productoIdEqu
        ])
        ->whereNull('fecha_eliminado')
        ->exists();
    }

    public function getEquivalenciasByProducto(string $productoId){
        return $this->db->table('equivalencias')
        ->leftJoin('productos as p1','equivalencias.productoId','p1.id')
        ->leftJoin('productos as p2','equivalencias.productoIdEqu','p2.id')
        ->where('p1.publicId',$productoId)
        ->whereNull('equivalencias.fecha_eliminado')
        ->select([
            'equivalencias.id',
            'equivalencias.publicId',
            'equivalencias.productoId',
            'p1.publicId as productoPublicId',
            'p2.publicId as equivalenciaPublicId',
            'p2.codigo as equivalenciaCodigo',
            'p2.nombre as equivalenciaNombre',
            'p2.descripcion as equivalenciaDescripcion',
            'equivalencias.created_at',
            'equivalencias.fecha_eliminado'
        ])
        ->get();
    }

}
