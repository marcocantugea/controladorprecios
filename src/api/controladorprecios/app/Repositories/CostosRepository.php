<?php

namespace App\Repositories;

use App\Contractors\Models\Costo;
use App\Contractors\Repositories\ICostosRepository;
use DateTime;
use Exception;
use Illuminate\Database\MySqlConnection;

class CostosRepository implements ICostosRepository
{
    private MySqlConnection $db;

    public function __construct(MySqlConnection $db) {
        $this->db=$db;
    }

    /**
     * @param Costo $model
     */
    public function add($model)
    {
        try {
            if(!$model instanceof Costo) throw new Exception("invalid instance of costo");
            if(empty($model->proveedorId) || empty($model->productoId)) throw new Exception("missing ids to insert");
            $this->db->table('costos')->insert([
                'publicId'=>uniqid(),
                'proveedorId'=>$model->proveedorId,
                'productoId'=>$model->productoId,
                'costo'=>$model->costo,
                'expira_en'=>$model->expira_en,
                'activo'=>true,
                'created_at' => new DateTime()
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update($model)
    {
        try {
            if(!$model instanceof Costo) throw new Exception("invalid instance of costo");
            if(empty($model->publicId)) throw new Exception("invalid id");
            $this->db->table('costos')
            ->where('publicId',$model->publicId)
            ->update([
                'costo'=>$model->costo,
                'updated_at'=>new DateTime()
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($id)
    {
        try {
            if(empty($id)) throw new Exception("invalid id");
            $this->db->table('costos')
            ->where('publicId',$id)
            ->update([
                'activo'=>false,
                'fecha_eliminado'=> new DateTime()
            ]);

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getById($id)
    {
        return $this->db->table('costos')
        ->where('costos.publicId',$id)
        ->leftJoin('proveedores','costos.proveedorId','proveedores.id')
        ->leftJoin('productos', 'costos.productoId','productos.id')
        ->select([
            'costos.Id',
            'costos.publicId',
            'productoId',
            'proveedorId',
            'costo',
            'costos.activo',
            'expira_en',
            'costos.created_at',
            'costos.updated_at',
            'costos.fecha_eliminado',
            'proveedores.publicId as proveedorPublicId',
            'proveedores.codigo as codigoProveedor',
            'proveedores.nombreCorto',
            'productos.nombre as nombreProducto',
            'productos.publicId as productoPublicId',
        ])
        ->first();
    }

    public function getCostosByProveedor($id){
        if(empty($id)) throw new Exception('invalid id');
        return $this->db->table('costos')
        ->leftJoin('proveedores','costos.proveedorId','proveedores.id')
        ->leftJoin('productos', 'costos.productoId','productos.id')
        ->where('proveedores.publicId',$id)
        ->whereNull('costos.fecha_eliminado')
        ->select([
            'costos.id',
            'costos.publicId',
            'costos.productoId',
            'costos.proveedorId',
            'costos.costo',
            'costos.activo',
            'costos.created_at',
            'costos.updated_at',
            'costos.expira_en',
            'costos.fecha_eliminado',
            'proveedores.id as proveedorId',
            'proveedores.publicId as proveedorPublicId',
            'proveedores.codigo',
            'proveedores.nombreCorto',
            'productos.Id as productoId',
            'productos.publicId as productoPublicId',
            'productos.nombre as nombreProducto'
        ])
        ->get();
    }

    public function getIdCostoByProveedorAndProductoId(string $proveedorPublicId,string $productoPublicId){
        if(empty($proveedorPublicId) || empty($productoPublicId)) throw new Exception("invalid ids");
        return $this->db->table('costos')
        ->leftJoin('productos', 'costos.productoId','productos.id')
        ->leftJoin('proveedores','costos.proveedorId','proveedores.id')
        ->where(['proveedores.publicId'=>$proveedorPublicId,'productos.publicId'=>$productoPublicId])
        ->whereNull('costos.fecha_eliminado')
        ->select([
            'costos.publicId'
        ])
        ->first();
    }

    public function existProveedorAndProduct(int $proveedorId,int $productoId){
        return $this->db->table('costos')
        ->where(['proveedorId'=>$proveedorId,'productoId'=>$productoId])
        ->whereNull('fecha_eliminado')
        ->exists();
    }

    public function existProveedorAndProductById(string $proveedorId,string $productoId){
        return $this->db->table('costos')
        ->leftJoin('productos', 'costos.productoId','productos.id')
        ->leftJoin('proveedores','costos.proveedorId','proveedores.id')
        ->where(['proveedores.publicId'=>$proveedorId,'productos.publicId'=>$productoId])
        ->whereNull('costos.fecha_eliminado')
        ->exists();
    }
}
