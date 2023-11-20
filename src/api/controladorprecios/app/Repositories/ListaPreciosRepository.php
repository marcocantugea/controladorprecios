<?php

namespace App\Repositories;

use App\Contractors\IMapper;
use App\Contractors\Models\ListaPrecio;
use App\Contractors\Repositories\IListaPreciosRepository;
use App\DTOs\ListaPreciosDTO;
use DateTime;
use Exception;
use Illuminate\Database\MySqlConnection;

class ListaPreciosRepository implements IListaPreciosRepository
{
    private const TABLE='listasprecios';
    private IMapper $mapper;
    private MySqlConnection $db;


    public function __construct(MySqlConnection $db,IMapper $mapper) {
        $this->mapper=$mapper;
        $this->db=$db;
    }

    /**
     * Add a Lista de Precios
     * @param ListaPrecio $model
     * @return void
     */
    public function add($model){
        try {
            if(empty($model->descripcion) || empty($model->codigo)) throw new Exception('invalid descripcion or codigo on lista de precios');

            $id=$this->db->table(self::TABLE)->insertGetId([
                'publicId'=>uniqid(""),
                'descripcion'=>$model->descripcion,
                'codigo'=>$model->codigo,
                'created_at'=>new DateTime(),
                'activo'=>false,
                'fecha_inicia' => $model->fecha_inicia,
                'fecha_expira' => $model->fecha_expira
            ]);

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Update ListaPrecio Descipciones
     * @param ListaPrecio $model
     * @return void
     */
    public function update($model){
    
        try {
            
            if(empty($model->publicid) || empty($model->descripcion) || empty($model->codigo)) throw new Exception('invalid id, descripcion or codigo on lista de precios');
            $id= $this->db->table(self::TABLE)->where('publicId',$model->publicid)->whereNull('fecha_eliminado')->first()->id;
            if(empty($id)) throw new Exception('invalid id');
            $this->db->table(self::TABLE)->where('id',$id)->update([
                'codigo'=>$model->codigo,
                'descripcion'=>$model->descripcion,
                'updated_at'=>new DateTime(),
                'activo'=>$model->activo,
                'fecha_inicia'=>$model->fecha_inicia,
                'fecha_expira'=>$model->fecha_expira
            ]);

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Delete Lista Precio
     * @param string $id
     * @return void
     */
    public function delete($id){
        
        try {
            if(empty($id)) throw new Exception('invalid id');
            
            $this->db->table(self::TABLE)->where('publicId',$id)->whereNull('fecha_eliminado')->update([
                'fecha_eliminado'=>new DateTime()
            ]);

        } catch (\Throwable $th) {
            throw $th;
        }

    }

    /**
     * Gets ListaPrecio obj
     * @param string $id
     * @return ListaPrecio|null
     */
    public function getById($id){
        try {
            
            if(empty($id)) throw new Exception('invalid id');
            $listaPrecio= $this->db->table(self::TABLE)->where('publicId',$id)->whereNull('fecha_eliminado')->select([
                'id',
                'publicId',
                'descripcion',
                'codigo',
                'activo',
                'fecha_eliminado',
                'created_at',
                'updated_at',
                'fecha_expira',
                'fecha_inicia'
            ])->first();

            $model= $this->mapper->map($listaPrecio);
            return $model;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Get listas de precios
     * @param bool $activas
     * @return array|null
     */
    public function getListasPrecios(bool $activas=true){
        try {
            $data=$this->db->table(self::TABLE)->whereNull('fecha_eliminado')->select([
                'id',
                'publicId',
                'descripcion',
                'codigo',
                'activo',
                'fecha_eliminado',
                'created_at',
                'updated_at',
                'fecha_expira',
                'fecha_inicia'
            ])->get();

            $models=[];
            $data->each(function($item) use (&$models) {
                $model= $this->mapper->map($item);
                array_push($models,$model);
            });

            return $models;

        } catch (\Throwable $th) {
            throw $th;
        }
    }

}
