<?php 

namespace App\Repositories;

use Illuminate\Database\MySqlConnection;
use App\Contractors\Models\Proveedor;
use App\Contractors\Models\ProveedorInfoBasic;
use App\Contractors\Models\ProveedorMarca;
use App\Contractors\Models\ProveedorProducto;
use App\Contractors\Repositories\IProveedorRepository;
use Exception;
use DateTime;

class ProveedoresRepository implements IProveedorRepository{

    private MySqlConnection $db;

    public function __construct(MySqlConnection $db) {
        $this->db = $db;
    }

    public function add($model)
    {
        if(!$model instanceof Proveedor) throw new Exception("model is not instance of proveedor", 1);
        $exist= $this->db->table('proveedores')->where(['codigo'=>$model->codigo],['nombreCotro'=>$model->nombreCorto])->exists();
        if($exist) throw new Exception('proveedor already exist');
        $this->db->table('proveedores')->insert(
            [
                'publicId'=> uniqid(),
                'codigo'=>$model->codigo,
                'nombreCorto'=>$model->nombreCorto,
                'activo'=>true,
                'created_at'=>new DateTime('now')
            ]
        );
    }

    public function update($model)
    {
        if(!$model instanceof Proveedor) throw new Exception("model is not instance of proveedor", 1);
        if(empty($model->publicId)) throw new Exception("invalid id", 1);
        $this->db->table('proveedores')->where('publicId',$model->publicId)
        ->update([
            'codigo'=>$model->codigo,
            'nombreCorto'=>$model->nombreCorto,
            'updated_at'=>new DateTime('now')
        ]);
    }

    public function delete($id)
    {
        if(empty($id)) throw new Exception("invalid id", 1);
        $this->db->table('proveedores')->where('publicId',$id)
        ->update([
            'activo'=>false,
            'fecha_eliminado'=> new DateTime('now')
        ]);
    }

    public function getById($id)
    {
        return $this->db->table('proveedores')
                            ->where('publicId',$id)
                            ->select([
                                'id',
                                'publicId',
                                'codigo',
                                'nombreCorto',
                                'activo',
                                'created_at',
                                'updated_at',
                                'fecha_eliminado'
                            ])
                            ->first()
                            ;
    }

    public function addProveedorInfoBasic(ProveedorInfoBasic $model){

        if(!isset($model->proveedorId)) throw new Exception("invalid id");
        $existRecord=$this->db->table('proveedoresInfoBasic')->where(['proveedorId'=>$model->proveedorId])->whereNull('fecha_eliminado')->exists();
        if($existRecord) throw new Exception("a basic data is already added, try to update resource");
        $this->db->table('proveedoresInfoBasic')->insert(
            [
                'proveedorId'=>$model->proveedorId,
                'publicId'=> uniqid(),
                'nombre'=>$model->nombre,
                'rasonSocial'=>$model->rasonSocial,
                'RFC'=>$model->RFC,
                'activo'=>true,
                'created_at'=>new DateTime('now')
            ]
        );
    }


    public function updateProveedorInfoBasic(ProveedorInfoBasic $model){

        if(empty($model->publicId)) throw new Exception("invalid id", 1);
        $this->db->table('proveedoresInfoBasic')->where('publicId',$model->publicId)->update(
            [
                'nombre'=>$model->nombre,
                'rasonSocial'=>$model->rasonSocial,
                'RFC'=>$model->RFC,
                'updated_at'=>new DateTime('now')
            ]
        );
    }

    public function deleteProveedorInfoBasic($id){
        if(empty($id)) throw new Exception("invalid id", 1);
        $this->db->table('proveedoresInfoBasic')->where('publicId',$id)
        ->update([
            'activo'=>false,
            'fecha_eliminado'=> new DateTime('now')
        ]);
    }

    public function getProveedorInfoBasic($id){
        return $this->db->table('proveedoresInfoBasic')->where('publicId',$id)
        ->select([
            'id',
            'proveedorId',
            'publicId',
            'nombre',
            'rasonSocial',
            'RFC',
            'activo',
            'created_at',
            'updated_at',
            'fecha_eliminado'
        ])->first();
    }

    public function getInfoBasicByProveedor(string $idProveedor){
        return $this->db->table('proveedoresInfoBasic')
        ->join('proveedores','proveedoresInfoBasic.proveedorId','proveedores.id')
        ->where('proveedores.publicId',$idProveedor)
        ->select([
            'proveedoresInfoBasic.id',
            'proveedoresInfoBasic.proveedorId',
            'proveedoresInfoBasic.publicId',
            'proveedoresInfoBasic.nombre',
            'proveedoresInfoBasic.rasonSocial',
            'proveedoresInfoBasic.RFC',
            'proveedoresInfoBasic.activo',
            'proveedoresInfoBasic.created_at',
            'proveedoresInfoBasic.updated_at',
            'proveedoresInfoBasic.fecha_eliminado'
        ])->first();
    }

    public function addProveedorMarca(ProveedorMarca $model){
        
        $exist=$this->db->table('proveedoresmarcas')->where(['proveedorId'=>$model->proveedorId,'marcaId'=>$model->marcaId])
        ->whereNull('fecha_eliminado')
        ->exists();

        if($exist) throw new Exception("proveedor and marca already added");
        $this->db->table('proveedoresmarcas')->insert(
            [
                'proveedorId'=>$model->proveedorId,
                'marcaId'=> $model->marcaId,
                'activo'=>true,
                'created_at'=>new DateTime('now')
            ]
        );
    }

    public function deleteProveedorMarca($id){
        if(empty($id)) throw new Exception("invalid id", 1);
        $this->db->table('proveedoresmarcas')->where('publicId',$id)
        ->update([
            'activo'=>false,
            'fecha_eliminado'=> new DateTime('now')
        ]);
    }

    public function addProveedorProducto(ProveedorProducto $model)
    {
        $this->db->table('proveedoresproductos')->insert(
            [
                'proveedorId'=>$model->proveedorId,
                'productoId'=> $model->productoId,
                'activo'=>true,
                'created_at'=>new DateTime('now')
            ]
        );
    }
    
    public function getProveedores(array $searchParams,int $limit=500,int $offset=0,bool $showDeleted=true){
        $query= $this->db->table('proveedores')->leftJoin('proveedoresInfoBasic','proveedoresInfoBasic.proveedorId','proveedores.id');

        foreach ($searchParams as $key => [$value,$operator]) {
            $query->where($key,empty($operator) ? '=' : $operator,$value);
        }
        if(!$showDeleted) $query->whereNull(['proveedores.fecha_eliminado']);

        $query=$query->select([
            'proveedores.id as proveedorId',
            'proveedores.publicId as proveedorPublicId',
            'proveedores.codigo',
            'proveedores.nombreCorto',
            'proveedores.activo as proveedorActivo',
            'proveedores.created_at as proveedorCreated_at',
            'proveedores.updated_at as proveedorUpdated_at',
            'proveedores.fecha_eliminado as ProveedorFecha_eliminado',
            'proveedoresInfoBasic.id as infoBasicId',
            'proveedoresInfoBasic.proveedorId',
            'proveedoresInfoBasic.publicId as infoBasicPublicId',
            'proveedoresInfoBasic.nombre',
            'proveedoresInfoBasic.rasonSocial',
            'proveedoresInfoBasic.RFC',
            'proveedoresInfoBasic.activo as infoBasicActivo',
            'proveedoresInfoBasic.created_at as infoBasicCreated_at',
            'proveedoresInfoBasic.updated_at  as infoBasicUpdated_at',
            'proveedoresInfoBasic.fecha_eliminado  as infoBasicFecha_eliminado'
        ])->skip($offset)->take($limit);

        return $query->get();
    }

    public function getProveedorByCode(string $codigo){
        return $this->db->table('proveedores')
        ->where('codigo',$codigo)
        ->select([
            'id',
            'publicId',
            'codigo',
            'nombreCorto',
            'activo',
            'created_at',
            'updated_at',
            'fecha_eliminado'
        ])
        ->first()
        ;
    }

    public function getMarcasByProveedor(string $proveedorId){
        return $this->db->table('proveedores')
        ->leftJoin('proveedoresmarcas','proveedoresmarcas.proveedorId','proveedores.id')
        ->leftJoin('marcas','proveedoresmarcas.marcaId','marcas.id')
        ->where(['proveedores.publicId'=>$proveedorId])
        ->whereNull('proveedoresmarcas.fecha_eliminado')
        ->select([
            'proveedoresmarcas.id as proveedoresmarcasId',
            'marcas.publicId as marcaPublicId',
            'marcas.marca',
            'marcas.activo as marcaActivo'
        ])
        ->get()
        ;

    }

    public function getProveedorMarcaByIds(string $proveedorId, string $marcaId){
        return $this->db->table('proveedores')
        ->leftJoin('proveedoresmarcas','proveedoresmarcas.proveedorId','proveedores.id')
        ->leftJoin('marcas','marca.Id','proveedoresmarcas.marcaId')
        ->where(['proveedores.publicId'=>$proveedorId,'marcas.publicId'=>$marcaId])
        ->whereNull('proveedoresmarcas.fecha_eliminado')
        ->select([
            'proveedoresmarcas.id as proveedoresmarcasId',
            'proveedores.publicId as proveedorPublicid',
            'marcas.publicId as marcaPublicId',
            'proveedoresmarcas.activo as proveedoresmarcasActivo',
            'proveedoresmarcas.created_at'
        ])
        ->get()
        ;
    }

}