<?php

namespace App\Repositories;

use App\Contractors\IMapper;
use App\Contractors\Models\Usuario;
use App\Contractors\Repositories\IUsuariosRepository;
use App\Mappers\RolMapper;
use DateTime;
use Exception;
use Illuminate\Database\MySqlConnection;

class UsuariosRepository implements IUsuariosRepository
{
    private const TABLE='usuarios';
    private const TABLE_ROL='roles_sistema';
    private const TABLE_USUARIO_ROL='usuario_rol';
    private const TABLE_ROL_ACCIONES='roles_acciones_sistema';
    private const TABLE_ACCIONES='acciones_sistema';
    private IMapper $rolMapper;

    private MySqlConnection $db;

    public function __construct(MySqlConnection $db,RolMapper $rolMapper) {
        $this->db = $db;
        $this->rolMapper=$rolMapper;
    }
    public function add($model)
    {
        if(!$model instanceof Usuario ) throw new Exception("invalid model");
        $this->db->table('usuarios')->insert(
            [
                'publicId'=>uniqid(),
                'user'=>$model->user,
                'hash'=>$model->hash,
                'email'=>$model->email,
                'active'=>false,
                'created_at'=>new DateTime('now')
            ]
        );
    }

    public function update($model)
    {
        if(!$model instanceof Usuario ) throw new Exception("invalid model");
        if(empty($model->publicId)) throw new Exception('invalid id to update');
        $this->db->table('usuarios')->where('publicId',$model->publicId)->update(
            [
                'user'=>$model->user,
                'hash'=>$model->hash,
                'email'=>$model->email
            ]
        );
    }

    public function delete($id)
    {
        if(empty($id)) throw new Exception('invalid id to update');
        $this->db->table('usuarios')->where('publicId',$id)->update(
            [
                'active'=>false,
                'deleted_at'=>new DateTime('now')
            ]
        );
    }

    public function getById($id)
    {
        if(empty($id)) throw new Exception("invalid product id", 1);
        return $this->db->table('usuarios')
        ->where('publicId',$id)
        ->where('active',true)
        ->whereNull('deleted_at')
        ->select([
            'id',
            'publicId',
            'user',
            'hash',
            'email',
            'active',
            'created_at',
            'updated_at',
            'deleted_at'
        ]
        )->first();
    }

    public function getUsuario(string $user){
        if(empty($user)) throw new Exception("invalid product id", 1);
        return $this->db->table('usuarios')
        ->where(['user'=>$user],['active'=>true])
        ->select([
            'publicId',
            'user',
            'hash',
            'email',
            'active',
            'created_at',
            'updated_at',
            'deleted_at'
        ]
        )->first();
    }

    public function getUsuarios(array $searchParams,int $limit=500,int $offset=0){
        $query= $this->db->table('usuarios');
        foreach ($searchParams as $key => [$value,$operator]) {
            $query->where($key,empty($operator) ? '=' : $operator,$value);
        }

        $query=$query->whereNull('deleted_at');

        return $query->select(
            [
                'publicId',
                'user',
                'email',
                'active',
                'created_at',
                'updated_at',
                'deleted_at'
            ]
        )->skip($offset)->take($limit)->get();
    }

    public function activateUsuario($id)
    {
        if(empty($id)) throw new Exception("invalid Id to update");
        $this->db->table('usuarios')->where('publicId',$id)->update([
            'active'=>true,
            'updated_at'=> new DateTime('now')
        ]);

        
    }

    public function deActivateUsuario($id)
    {
        if(empty($id)) throw new Exception("invalid Id to update");
        $this->db->table('usuarios')->where('publicId',$id)->whereNull('deleted_at')->update([
            'active'=>false,
            'updated_at'=> new DateTime('now')
        ]);

        
    }

    public function getAcciones($pid)
    {
        if(empty($pid)) throw new Exception('invalid id');
        $acciones=$this->db->table($this::TABLE_USUARIO_ROL)
        ->join($this::TABLE_ROL_ACCIONES,$this::TABLE_ROL_ACCIONES.'.rolId','=',$this::TABLE_USUARIO_ROL.'.rolId')
        ->join($this::TABLE_ACCIONES,$this::TABLE_ACCIONES.'.Id','=',$this::TABLE_ROL_ACCIONES.'.accionId')
        ->select($this::TABLE_ACCIONES.'.accion')
        ->where('usuarioPid',$pid)
        ->whereNull($this::TABLE_USUARIO_ROL.'.fecha_eliminado')
        ->whereNull($this::TABLE_ROL_ACCIONES.'.fecha_eliminado')
        ->whereNull($this::TABLE_ACCIONES.'.fecha_eliminado')
        ->get($this::TABLE_ACCIONES.'.accion')
        ->toArray()
        ;

        return $acciones;
    }

    public function getUserRol($pid){
        if(empty($pid)) throw new Exception('invalid id');

        $item=$this->db->table($this::TABLE_USUARIO_ROL)
        ->join('roles_sistema','roles_sistema.id','=',$this::TABLE_USUARIO_ROL.'.rolId')
        ->where($this::TABLE_USUARIO_ROL.'.usuarioPid',$pid)
        ->whereNull($this::TABLE_USUARIO_ROL.'.fecha_eliminado')
        ->select([
            'roles_sistema.publicId',
            'roles_sistema.id',
            'roles_sistema.rol',
            'roles_sistema.activo',
            'roles_sistema.created_at',
            'roles_sistema.updated_at',
            'roles_sistema.fecha_eliminado'
            ])
        ->first();

        $model=$this->rolMapper->map($item);

        return $model;
    }

    public function updatePasswordUsario(string $pid, string $hash)
    {
        if(empty($pid) || empty($hash)) throw new Exception('invalid id or password');

        $this->db->table($this::TABLE)->where('publicId',$pid)->whereNull('deleted_at')->update([
            'hash'=>$hash,
            'updated_at'=>new DateTime()
        ]);


    }
}
