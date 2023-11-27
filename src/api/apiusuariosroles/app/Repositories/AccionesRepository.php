<?php

namespace App\Repositories;

use App\Contractors\IMapper;
use App\Contractors\Models\Accion;
use App\Contractors\Repositories\IAccionesRepository;
use Illuminate\Database\MySqlConnection;

class AccionesRepository implements IAccionesRepository
{
    private const TABLE ='acciones_sistema' ;
    private MySqlConnection $db;
    private IMapper $mapper;

    public function __construct(MySqlConnection $db,IMapper $mapper) {
        $this->db=$db;
        $this->mapper=$mapper;
    }

    public function getAccionById($pid)
    {
        $item=$this->db->table($this::TABLE)->where('publicId',$pid)->whereNull('fecha_eliminado')
        ->select($this->getModelFields())
        ->first();

        $model=$this->mapper->map($item);

        return $model;
    }

    public function getAcciones()
    {
        $items=$this->db->table($this::TABLE)->whereNull('fecha_eliminado')
        ->select($this->getModelFields())
        ->get();

        $models=[];
        $items->each(function($item) use (&$models){
            $model=$this->mapper->map($item);
            array_push($models,$model);
        });
        
        return $models;
    }

    
    public function getModelFields(){
        return array_keys(get_class_vars(get_class(new Accion())));
    }
}
