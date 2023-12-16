<?php

namespace App\Repositories;

use App\Contractors\IMapper;
use App\Contractors\Models\RolUsuario;
use App\Contractors\Repositories\IRolUsuarioRepository;
use DateTime;
use Exception;
use Illuminate\Database\MySqlConnection;

class RolUsuarioRepository implements IRolUsuarioRepository
{
    private MySqlConnection $db;
    private IMapper $mapper;
    private const TABLE='usuario_rol';

    public function __construct(MySqlConnection $db,IMapper $mapper) {
        $this->db = $db;
        $this->mapper=$mapper;
    }

    /**
     * add model
     * @param RolUsuario $model
     * @return string|null 
     */
    public function add($model)
    {
        if(empty($model->usuarioPid) || empty($model->rolPid) || empty($model->usuarioId) || empty($model->rolId)) throw new Exception('invalid ids');
        $exist=$this->db->table($this::TABLE)->where('usuarioPid',$model->usuarioPid)->where('rolPid',$model->rolPid)->whereNull('fecha_eliminado')->exists();
        if($exist) throw new Exception('record already exist');
        $existingRecords=$this->db->table($this::TABLE)->where('usuarioPid',$model->usuarioPid)->whereNull('fecha_eliminado')->count();
        if($existingRecords>0){
            $this->db->table($this::TABLE)->where('usuarioPid',$model->usuarioPid)->whereNull('fecha_eliminado')->update([
                'fecha_eliminado'=>new DateTime()
            ]);
        }
        $id=$this->db->table($this::TABLE)->insertGetId([
            'publicId'=>uniqid(),
            'usuarioPid'=>$model->usuarioPid,
            'rolPid'=>$model->rolPid,
            'usuarioId'=>$model->usuarioId,
            'rolId'=>$model->rolId,
            'created_at'=>new DateTime()
        ]);

        $publicId=$this->db->table($this::TABLE)->where('id',$id)->select('publicId')->first('publicId')->publicId;
        return $publicId;
    }

    public function update($model)
    {
        throw new Exception('not implemented');
    }
    
    public function  delete($id)
    {
        if(empty($id)) throw new Exception('invalid id');
        $this->db->table($this::TABLE)->where('publicId',$id)->whereNull('fecha_eliminado')->update([
            'fecha_eliminado'=>new DateTime()
        ]);
    }

    public function getById($id)
    {
     
        if(empty($id)) throw new Exception('invalid id');
        $info=$this->db->table($this::TABLE)->where('publicId',$id)->whereNull('fecha_eliminado')
        ->select($this->getModelFields())
        ->first();

        $model=$this->mapper->map($info);

        return $model;
    }

    public function getRolByUserId(string $usuarioPid)
    {
        if(empty($usuarioPid)) throw new Exception('invalid id');
        $info=$this->db->table($this::TABLE)->where('usuarioPid',$usuarioPid)->whereNull('fecha_eliminado')
        ->select($this->getModelFields())
        ->first();

        $model=$this->mapper->map($info);

        return $model;
    }

    public function getModelFields(){
        return array_keys(get_class_vars(get_class(new RolUsuario())));
    }
}
