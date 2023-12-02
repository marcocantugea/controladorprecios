<?php

namespace App\Repositories;

use App\Contractors\IMapper;
use App\Contractors\Models\Modulo;
use App\Contractors\Repositories\IModuloRepository;
use DateTime;
use Exception;
use Illuminate\Database\Connectors\MySqlConnector;
use Illuminate\Database\MySqlConnection;

class ModuloRepository implements IModuloRepository
{
    private const TABLE_NAME ='modulos_sistema';
    private MySqlConnection $db;
    private IMapper $mapper;

    public function __construct(MySqlConnection $db,IMapper $mapper) {
        $this->db=$db;
        $this->mapper=$mapper;
    }

    /**
     * add model
     * @param Modulo $model
     * @return string|null
     */
    public function add($model)
    {
        if(empty($model->nombre) || empty($model->display)) throw new Exception('invalida nombre or display');
        $exist=$this->db->table($this::TABLE_NAME)->where('nombre',$model->nombre)->where('display',$model->display)->whereNull('fecha_eliminado')->exists();
        if($exist) throw new Exception('Modulo already exists');
        $id=$this->db->table($this::TABLE_NAME)->insertGetId([
            'publicId'=>uniqid(),
            'nombre'=>$model->nombre,
            'display'=>$model->display,
            'activo'=>false,
            'created_at'=>new DateTime()
        ]);

        $publicId=$this->db->table($this::TABLE_NAME)->where('id',$id)->first('publicId')->publicId;
        return $publicId;
    }

    /**
     * update model
     * @param Modulo $model
     * @return void
     */
    public function update($model)
    {
        if(empty($model->nombre) || empty($model->display) || empty($model->publicId)) throw new Exception('invalida nombre or display');
        $this->db->table($this::TABLE_NAME)->where('publicId',$model->publicId)->whereNull('fecha_eliminado')->update(
            [
                'nombre'=>$model->nombre,
                'display'=>$model->display,
                'activo'=>$model->activo,
                'updated_at'=>new DateTime()
            ]
        );

    }

    /**
     * get model by id
     */
    public function getById($pid)
    {
        if(empty($pid)) throw new Exception('invalid id');
        $item=$this->db->table($this::TABLE_NAME)->where('publicId',$pid)->whereNull('fecha_eliminado')
        ->select($this->getModelFields())
        ->first();

        $model=$this->mapper->map($item);

        return $model;
    }

    public function delete($pid)
    {
        if(empty($pid)) throw new Exception('invalid id');
        $this->db->table($this::TABLE_NAME)->where('publicId',$pid)->whereNull('fecha_eliminado')->update([
            'fecha_eliminado'=>new DateTime()
        ]);

    }

    public function getModulos()
    {
        $items=$this->db->table($this::TABLE_NAME)->where('fecha_eliminado')
        ->select($this->getModelFields())
        ->get();

        $models=[];
        $items->each(function($item) use (&$models){
            $model=$this->mapper->map($item);
            if(!empty($model)) array_push($models,$model);
        });

        return $models;
    }


    public function getModulosByRol(string $rolPid)
    {
        $fields=[];
        $fieldKeys=$this->getModelFields();
        array_walk($fieldKeys,function($field) use (&$fields){
            $field=$this::TABLE_NAME.'.'.$field;
            array_push($fields,$field);
        });

        $items=$this->db->table($this::TABLE_NAME)
        ->join('roles_modulos','roles_modulos.moduloId','=',$this::TABLE_NAME.'.Id')
        ->where('roles_modulos.rolPid',$rolPid)
        ->whereNull($this::TABLE_NAME.'.fecha_eliminado')
        ->whereNull('roles_modulos.fecha_eliminado')
        ->select($fields)
        ->get();

        $models=[];
        $items->each(function($item) use (&$models){
            $model=$this->mapper->map($item);
            if(!empty($model)) array_push($models,$model);
        });

        return $models;
    }

    public function getModelFields(){
        return array_keys(get_class_vars(get_class(new Modulo())));
    }
}
