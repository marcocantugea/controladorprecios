<?php

namespace App\Repositories;

use App\Contractors\IMapper;
use App\Contractors\Models\RolAccion;
use App\Contractors\Repositories\IRolAccionRepository;
use DateTime;
use Exception;
use Illuminate\Database\MySqlConnection;

class RolAccionRepository implements IRolAccionRepository
{
    private const TABLE_NAME ='roles_acciones_sistema';
    private const TABLE_ROL_NAME='roles_sistema';
    private const TABLE_ACCION_NAME='acciones_sistema';
    private MySqlConnection $db;
    private IMapper $mapper;

    public function __construct(MySqlConnection $db,IMapper $mapper) {
        $this->db=$db;
        $this->mapper=$mapper;
    }

    /**
     * add model
     * @param RolAccion $model
     * @return string|null
     */
    public function add($model)
    {
        if(empty($model->rolPid) && empty($model->accionPid)) throw new Exception('invalid ids');
        
        $idRol= $this->db->table($this::TABLE_ROL_NAME)->where('publicId',$model->rolPid)->whereNull('fecha_eliminado')->select(['id'])->first('id')->id;
        $idAccion=$this->db->table($this::TABLE_ACCION_NAME)->where('publicId',$model->accionPid)->whereNull('fecha_eliminado')->select(['id'])->first('id')->id;
        $model->rolId=$idRol;
        $model->accionId=$idAccion;

        $id=$this->db->table($this::TABLE_NAME)->insertGetId([
            'publicId'=>uniqid(),
            'rolId'=>$model->rolId,
            'accionId'=>$model->accionId,
            'rolPid'=>$model->rolPid,
            'accionPid'=>$model->accionPid,
            'created_at'=>new DateTime()
        ]);

        $publicId=$this->db->table($this::TABLE_NAME)->where('id',$id)->select('publicId')->first('publicId')->publicId;
        return $publicId;
    }

    public function update($model)
    {
        throw new Exception('not implemented');
    }

    public function delete($id)
    {
        if(empty($id)) throw new Exception('invalid id');
        $this->db->table($this::TABLE_NAME)->where('publicId',$id)->update([
            'fecha_eliminado'=>new DateTime()
        ]);
    }

    public function getById($id)
    {
        if(empty($id)) throw new Exception('invalid id');
        $item= $this->db->table($this::TABLE_NAME)->where('publicId',$id)->whereNull('fecha_eliminado')->select($this->getModelFields())
        ->first();

        $model=$this->mapper->map($item);

        return $model;
    }

    public function getAccionesPorRol($rolPid){
        if(empty($rolPid)) throw new Exception('invalid id');
        $items= $this->db->table($this::TABLE_NAME)->where('rolPid',$rolPid)->whereNull('fecha_eliminado')
        ->select($this->getModelFields())
        ->get();

        $models=[];
        $items->each(function($item) use (&$models){
            $model=$this->mapper->map($item);
            if(!empty($model)) array_push($models,$model);
        });

        return $models;
    }

    public function getAccionesRoles(){

        $items= $this->db->table($this::TABLE_NAME)->whereNull('fecha_eliminado')
        ->select($this->getModelFields())
        ->get();

        $models=[];
        $items->each(function($item) use (&$models){
            $model=$this->mapper->map($item);
            if(!empty($model)) array_push($models,$model);
        });

        return $models;
    }

    public function addAccionesARole(array $models)
    {
        $publicIds=[];
        array_walk($models, function($model) use (&$publicIds){
            $publicId=$this->add($model);
            array_push($publicIds,$publicId);
        });

        return $publicIds;
    }

    public function getModelFields(){
        return array_keys(get_class_vars(get_class(new RolAccion())));
    }
}
