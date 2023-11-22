<?php

namespace App\Repositories;

use App\Contractors\IMapper;
use App\Contractors\Models\CanalVenta;
use App\Contractors\Repositories\ICanalesVentaRepository;
use App\Mappers\CanalesVentaMapper;
use DateTime;
use Exception;
use Illuminate\Database\MySqlConnection;

class CanalesVentaRepository implements ICanalesVentaRepository
{
    private const TABLE_NAME='canalesventa';
    private MySqlConnection $db;
    private IMapper $mapper;

    public function __construct(MySqlConnection $connection, CanalesVentaMapper $mapper) {
        $this->db= $connection;
        $this->mapper=$mapper;
    }

    /**
     * Add new Model 
     * @param CanalVenta $model
     * @return void
     */
    public function add($model){
        if(empty($model->nombre)) throw new Exception('invalid nombre');
        if($this->ExistCanalVenta($model->nombre)) throw new Exception('canal venta existente');
        $id=$this->db->table($this::TABLE_NAME)->insertGetId([
            'publicId'=>uniqid(),
            'nombre'=>$model->nombre,
            'codigo'=>$model->codigo,
            'activo'=>true,
            'created_at'=>new DateTime()
        ]);

        $publicId=$this->db->table($this::TABLE_NAME)->where('id',$id)->first()->publicId;
        return $publicId;
    }

     /**
     * Update new Model 
     * @param CanalVenta $model
     * @return void
     */
    public function update($model){
        if(empty($model->publicId)) throw new Exception('invalid id');
        $this->db->table($this::TABLE_NAME)->where('publicId',$model->publicId)
        ->update([
            'nombre'=>$model->nombre,
            'codigo'=>$model->codigo,
            'activo'=>boolval($model->activo),
            'updated_at'=>new DateTime()
        ]);
    }

    public function getById($pid){
        if(empty($pid)) throw new Exception("invalid id");
        
        $fieldsFomClass=array_keys(get_class_vars(get_class(new CanalVenta())));

        $data= $this->db->table($this::TABLE_NAME)->where('publicId',$pid)->whereNull('fecha_eliminado')
        ->select($fieldsFomClass)
        ->first();

        $model=$this->mapper->map($data);
        return $model;
    }

    public function delete($pid){
        if(empty($pid)) throw new Exception("invalid id");
        $this->db->table($this::TABLE_NAME)->where('publicId',$pid)->whereNull('fecha_eliminado')->update(
            ['fecha_eliminado' =>  new DateTime()]
        );
    }

    public function ExistCanalVenta(string $nombre){
        return $this->db->table($this::TABLE_NAME)->where('nombre',$nombre)->whereNull('fecha_eliminado')->exists();
    }

    public function getCanalesVenta()
    {
        $fieldsFomClass=array_keys(get_class_vars(get_class(new CanalVenta())));

        $data= $this->db->table($this::TABLE_NAME)->whereNull('fecha_eliminado')
        ->select($fieldsFomClass)
        ->get();

        $models=[];
        $data->each(function($item) use (&$models){
            $model=$this->mapper->map($item);
            array_push($models,$model);
        });

        return $models;
    }
}
