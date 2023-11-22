<?php

namespace App\Repositories;

use App\Contractors\IMapper;
use App\Contractors\Repositories\ICanalVentaListaPrecioRepository;
use App\Mappers\CanalVentaListaPrecioMapper;
use App\Contractors\Models\CanalVentaListaPrecio;
use DateTime;
use Exception;
use Illuminate\Database\MySqlConnection;

class CanalVentaListaPrecioRepository implements ICanalVentaListaPrecioRepository
{
    private const TABLE_NAME='canalventa_listaprecio';
    private MySqlConnection $db;
    private IMapper $mapper;

    public function __construct(MySqlConnection $connection, CanalVentaListaPrecioMapper $mapper) {
        $this->db= $connection;
        $this->mapper=$mapper;
    }
    
    /**
     * Add model
     * @param CanalVentaListaPrecio $model
     * @return string|null
     */
    public function add($model)
    {
        if(empty($model->listaPid)) throw new Exception('invalid lista id');
        if($this->existListaEnCanal($model->listaPid,$model->canalventaPid)) throw new Exception('lista ya existe en canal de venta');

        //obtener id de canal venta
        $idCanalVenta=$this->db->table('canalesventa')->where('publicId',$model->canalventaPid)->whereNull('fecha_eliminado')->first()->id;
        $model->canalventaId=$idCanalVenta;

        $id=$this->db->table($this::TABLE_NAME)->insertGetId([
            'publicId'=>uniqid(),
            'listaPid'=>$model->listaPid,
            'canalventaPid'=>$model->canalventaPid,
            'canalventaId'=>$model->canalventaId,
            'created_at'=>new DateTime()
        ]);

        $publicId= $this->db->table($this::TABLE_NAME)->where('id',$id)->first()->publicId;

        return $publicId;
    }

    public function update($model)
    {
        throw new Exception('not implemented');
    }

    public function getById($pid)
    {
        if(empty($pid)) throw new Exception('invalid id');
        $data= $this->db->table($this::TABLE_NAME)->where('publicId',$pid)->whereNull('fecha_eliminado')
        ->select($this->getModelFields())
        ->first();
        $model= $this->mapper->map($data);
        return $model;
    }

    public function delete($pid)
    {
        if(empty($pid)) throw new Exception('invalid id');
        $this->db->table($this::TABLE_NAME)->where('publicId',$pid)->whereNull('fecha_eliminado')->update(
            [
                'fecha_eliminado'=>new DateTime()
            ]
        );
    }

    public function getListasPrecioPorCanalVenta($pid){
        if(empty($pid)) throw new Exception('invalid id');
        $data= $this->db->table($this::TABLE_NAME)->where('canalventaPid',$pid)->whereNull('fecha_eliminado')
        ->select($this->getModelFields())
        ->get();

        $models=[];
        $data->each(function($item) use (&$models){
            $model=$this->mapper->map($item);
            array_push($models,$model);
        });

        return $models;
    }

    public function existListaEnCanal($listaPid,$canalventaPid){
        return $this->db->table($this::TABLE_NAME)->where('listaPid',$listaPid)->where('canalventaPid',$canalventaPid)->whereNull('fecha_eliminado')->exists();
    }

    public function getModelFields(){
        return array_keys(get_class_vars(get_class(new CanalVentaListaPrecio())));
    }
}
