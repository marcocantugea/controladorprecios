<?php

namespace App\Repositories;

use App\Contractors\Models\Usuario;
use App\Contractors\Repositories\IUsuariosRepository;
use App\Models\User;
use DateTime;
use Exception;
use Illuminate\Database\MySqlConnection;

class UsuariosRepository implements IUsuariosRepository
{
    private MySqlConnection $db;

    public function __construct(MySqlConnection $db) {
        $this->db = $db;
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
        ->where('deleted_at',"!=",null)
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
}
