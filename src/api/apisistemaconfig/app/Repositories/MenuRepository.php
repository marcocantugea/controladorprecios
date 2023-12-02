<?php

namespace App\Repositories;

use App\Contractors\IMapper;
use App\Contractors\Models\Menu;
use App\Contractors\Models\Modulo;
use App\Contractors\Repositories\IMenuRepository;
use DateTime;
use Exception;
use Illuminate\Database\MySqlConnection;

class MenuRepository implements IMenuRepository
{
    private const TABLE_NAME='menus_sistema';
    private MySqlConnection $db;
    private IMapper $mapper;

    public function __construct(MySqlConnection $db,IMapper $mapper)
    {
        $this->db=$db;
        $this->mapper=$mapper;
    }

    public function add($model)
    {
        if(empty($model->nombre) || empty($model->display)) throw new Exception('invalida nombre or display');
        $exist=$this->db->table($this::TABLE_NAME)->where('nombre',$model->nombre)->where('display',$model->display)->whereNull('fecha_eliminado')->exists();
        if($exist) throw new Exception('Menu already exists');
        $id=$this->db->table($this::TABLE_NAME)->insertGetId([
            'publicId'=>uniqid(),
            'nombre'=>$model->nombre,
            'display'=>$model->display,
            'activo'=>false,
            'essubmenu'=>$model->essubmenu,
            'submenuId'=>(empty($model->submenuId)) ? null : $model->submenuId,
            'orden'=>$model->orden,
            'accion'=>$model->accion,
            'created_at'=>new DateTime()
        ]);

        $publicId=$this->db->table($this::TABLE_NAME)->where('id',$id)->first('publicId')->publicId;
        return $publicId;
    }

    public function delete($pid)
    {
        if(empty($pid)) throw new Exception('invalid id');
        $this->db->table($this::TABLE_NAME)->where('publicId',$pid)->whereNull('fecha_eliminado')
        ->update([
            'fecha_eliminado'=>new DateTime()
        ]);

    }

    public function update($model)
    {
        if(empty($model->publicId)) throw new Exception('invalid id');
        $this->db->table($this::TABLE_NAME)->where('publicId',$model->publicId)->update([
            'nombre'=>$model->nombre,
            'display'=>$model->display,
            'activo'=>false,
            'essubmenu'=>$model->essubmenu,
            'submenuId'=>(empty($model->submenuId)) ? null : $model->submenuId,
            'orden'=>$model->orden,
            'accion'=>$model->accion,
            'updated_at'=> new DateTime()
        ]);

    }

    public function getById($pid)
    {
        if(empty($pid)) throw new Exception('invalid id');
        $item= $this->db->table($this::TABLE_NAME)->where('publicId',$pid)->whereNull('fecha_eliminado')
        ->select($this->getModelFields())
        ->first();

        $model= $this->mapper->map($item);

        return $model;
    }

    public function getMenus(){
        $items=$this->db->table($this::TABLE_NAME)->whereNull('fecha_eliminado')->select($this->getModelFields())
        ->get();

        $models=[];
        $items->each(function($item) use (&$models){
            $model=$this->mapper->map($item);
            if(!empty($model)) array_push($models,$model);
        });

        return $models;
    }

    public function getMenusByModulo(string $moduloPid){

        $fields=[];
        $fielsFromModel=$this->getModelFields();
        array_walk($fielsFromModel,function($field) use (&$fields){
            $f=$this::TABLE_NAME.'.'.$field;
            array_push($fields,$f);
        });

        $items= $this->db->table('modulos_menus_sistema')
        ->join($this::TABLE_NAME,'menus_sistema.Id','=','modulos_menus_sistema.menuId')
        ->where('modulos_menus_sistema.moduloPid',$moduloPid)
        ->whereNull('modulos_menus_sistema.fecha_eliminado')
        ->whereNull($this::TABLE_NAME.'.fecha_eliminado')
        ->select($fields)
        ->get();

        $models=[];
        $items->each(function($item) use (&$models){  
            $model=$this->mapper->map($item);
            if(!empty($model)) array_push($models,$model);
        });

        return $models;
    }

    public function getMenuYModulosPorUsuario()
    {
        if(!isset($_SESSION['rolPid'])) throw new Exception('user rol is not set on session');
        $usuarioRol=$_SESSION['rolPid'];

        $items=$this->db->table('roles_modulos')
        ->join('modulos_sistema','modulos_sistema.id','=','roles_modulos.moduloId')
        ->join('modulos_menus_sistema','modulos_menus_sistema.moduloId','=','roles_modulos.moduloId')
        ->join('menus_sistema','menus_sistema.id','=','modulos_menus_sistema.menuId')
        ->where('roles_modulos.rolPid',$usuarioRol)
        ->whereNull('roles_modulos.fecha_eliminado')
        ->whereNull('modulos_sistema.fecha_eliminado')
        ->whereNull('modulos_menus_sistema.fecha_eliminado')
        ->whereNull('menus_sistema.fecha_eliminado')
        ->select([
            'modulos_sistema.publicId as moduloPid',
            'modulos_sistema.nombre as moduloNombre',
            'modulos_sistema.display as moduloDisplay',
            'modulos_sistema.activo as moduloActio',
            'menus_sistema.publicId as menuPid',
            'menus_sistema.nombre as menuNombre',
            'menus_sistema.display as menuDisplay',
            'menus_sistema.activo as menuActivo',
            'menus_sistema.essubmenu as essubmenu',
            'menus_sistema.orden as orden',
            'menus_sistema.submenuId as submenuId',
            'menus_sistema.accion as accion',
        ])
        ->get();

        return $items;
    }

    public function getModelFields(bool $addTable=false){
        if(!$addTable) return array_keys(get_class_vars(get_class(new Menu())));
        $fields=[];
        $fieldsObject=array_keys(get_class_vars(get_class(new Menu())));
        array_walk($fieldsObject,function($fieldObj) use (&$fields){
            array_push($fields,$this::TABLE_NAME.'.'.$fieldObj);
        });

        return $fields;
    }

    public function getModuloFields(bool $addTable=false){
        if(!$addTable) return array_keys(get_class_vars(get_class(new Modulo())));
        $fields=[];
        $fieldsObject=array_keys(get_class_vars(get_class(new Modulo())));
        array_walk($fieldsObject,function($fieldObj) use (&$fields){
            array_push($fields,'modulos_sistema.'.$fieldObj);
        });

        return $fields;
    }
}
