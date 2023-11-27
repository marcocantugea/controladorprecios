<?php

namespace App\Repositories;

use App\Contractors\IMapper;
use App\Contractors\Models\Rol;
use App\Contractors\Repositories\IRolesRepository;
use DateTime;
use Exception;
use Illuminate\Database\MySqlConnection;

class RolesRepository implements IRolesRepository
{
    private const TABLE ='roles_sistema' ;
    private MySqlConnection $db;
    private IMapper $mapper;

    public function __construct(MySqlConnection $db,IMapper $mapper) {
        $this->db=$db;
        $this->mapper=$mapper;
    }

    /**
     * Add model
     * @param Rol $model
     * @return string|null
     */
    public function add($model)
    {
        $exist=$this->db->table($this::TABLE)->where('rol',$model->rol)->exists(); 
        if($exist) throw new Exception('rol already exist');

        $id=$this->db->table($this::TABLE)->insertGetId(
            [
                'publicId'=>uniqid(),
                'rol'=>$model->rol,
                'activo'=>true,
                'created_at'=>new DateTime()
            ]
        );

        $publicId=$this->db->table($this::TABLE)->where('id',$id)->first('publicId')->publicId;

        return $publicId;

    }

    /**
     * udpdate model
     * @param Rol $model
     * @return void
     */
    public function update($model)
    {
        if(empty($model->publicId)) throw new Exception('invalid id');
        $this->db->table($this::TABLE)->where('publicId',$model->publicId)->whereNull('fecha_eliminado')->update(
            [
                'rol'=>$model->rol,
                'activo'=>$model->activo,
                'updated_at'=>new DateTime()
            ]
        );
    }

     /**
     * udpdate model
     * @param Rol $model
     * @return void
     */
    public function delete($pid)
    {
        if(empty($pid)) throw new Exception('invalid id');
        $this->db->table($this::TABLE)->where('publicId',$pid)->whereNull('fecha_eliminado')->update(
            [
                'fecha_eliminado'=>new DateTime()
            ]
        );
    }

     /**
     * udpdate model
     * @param string $pid
     * @return Rol
     */
    public function getById($pid)
    {
        $item=$this->db->table($this::TABLE)
        ->where('publicId',$pid)
        ->whereNull('fecha_eliminado')
        ->select($this->getModelFields())
        ->first()
        ;

        $model=$this->mapper->map($item);

        return $model;
    }

    public function getRoles()
    {
        $items=$this->db->table($this::TABLE)
        ->whereNull('fecha_eliminado')
        ->select($this->getModelFields())
        ->get()
        ;

        $models=[];
        $items->each(function($item) use (&$models){
            $model=$this->mapper->map($item);
            if(!empty($model)) array_push($models,$model);
        });

        return $models;
    }

    public function getModelFields(){
        return array_keys(get_class_vars(get_class(new Rol())));
    }
}
