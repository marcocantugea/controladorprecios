<?php

namespace App\Repositories;

use App\Contractors\IMapper;
use App\Contractors\Models\Modulo;
use App\Contractors\Models\RolModulo;
use App\Contractors\Repositories\IModuloRepository;
use DateTime;
use Exception;
use Illuminate\Database\Connectors\MySqlConnector;
use Illuminate\Database\MySqlConnection;

use function FastRoute\TestFixtures\empty_options_cached;

class ModuloRepository implements IModuloRepository
{
    private const TABLE_NAME ='modulos_sistema';
    private const TABLE_MODULO_ROL='roles_modulos';
    private MySqlConnection $db;
    private IMapper $mapper;
    private IMapper $rolModuloMapper; 

    public function __construct(MySqlConnection $db,IMapper $mapper,IMapper $rolModuloMapper) {
        $this->db=$db;
        $this->mapper=$mapper;
        $this->rolModuloMapper=$rolModuloMapper;
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

    private function getModelFields(){
        return array_keys(get_class_vars(get_class(new Modulo())));
    }

    public function getModelFieldsRolModulo(){
        return array_keys(get_class_vars(get_class(new RolModulo())));
    }

    public function addModuloRol(RolModulo $rolmodulo)
    {
        if(empty($rolmodulo->rolPid) || empty($rolmodulo->moduloPid)) throw new Exception('invalid ids');

        $exist= $this->db->table($this::TABLE_MODULO_ROL)->where('rolPid',$rolmodulo->rolPid)
                ->where('moduloPid',$rolmodulo->moduloPid)->whereNull('fecha_eliminado')
                ->exists();

        if($exist) throw new Exception('relacion rol y menu ya existente');

        $moduloId = $this->db->table($this::TABLE_NAME)->where('publicId',$rolmodulo->moduloPid)->whereNull('fecha_eliminado')
        ->select('id')->first()->id;

        if(empty($moduloId)) throw new Exception('invlaid modulo id');

        $rolmodulo->moduloId=$moduloId;

        $id=$this->db->table($this::TABLE_MODULO_ROL)->insertGetId([
            'publicId'=>uniqid(),
            'rolPid'=>$rolmodulo->rolPid,
            'moduloPid'=>$rolmodulo->moduloPid,
            'moduloId'=>$rolmodulo->moduloId,
            'created_at'=>new DateTime()
        ]);

        $publicId=$this->db->table($this::TABLE_MODULO_ROL)->where('id',$id)->select('publicId')->first()->publicId;

        return $publicId;
    }

    public function deleteModuloRol(string $pid)
    {
        if(empty($pid)) throw new Exception('invalid id');
        $this->db->table($this::TABLE_MODULO_ROL)->where('publicId',$pid)->whereNull('fecha_eliminado')
        ->update([
            'fecha_eliminado'=>new DateTime()
        ]);
    }

    public function getRolModulosIds(string $rolPid)
    {
        if(empty($rolPid)) throw new Exception('invalid id');
        $data=$this->db->table($this::TABLE_MODULO_ROL)->where('rolPid',$rolPid)
        ->whereNull('fecha_eliminado')
        ->select($this->getModelFieldsRolModulo())
        ->get();

        $models=[];
        $data->each(function ($item) use (&$models){
            $model=$this->rolModuloMapper->map($item);
            if(!empty($model)) array_push($models,$model);
        });

        return $models;
    }

}
