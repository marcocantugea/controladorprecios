<?php 

namespace App\Repositories;

use App\Contractors\IMapper;
use App\Contractors\Models\ListaPreciosProducto;
use App\Contractors\Repositories\IListaPreciosProductoRepository;
use DateTime;
use Exception;
use Illuminate\Database\MySqlConnection;

final class ListaPreciosProductoRepository implements IListaPreciosProductoRepository
{
    private MySqlConnection $db;
    private IMapper $mapper;
    private const TABLE="listapreciosproductos";

    public function __construct(MySqlConnection $db,IMapper $mapper) {
        $this->db=$db;
        $this->mapper=$mapper;
    }

    /**
     * Add new Lista precios producto
     * @param ListaPreciosProducto $model
     * @return string|null
     */
    public function add($model){
        try {
            if(empty($model->precio) || empty($model->productoId) || empty($model->productoPId) || empty($model->listaPid) || empty($model->listapreciosId)) throw new Exception('invalid producto o precio');
            $id=$this->db->table(self::TABLE)->insertGetId([
                'publicId'=>uniqid(),
                'productoPId'=>$model->productoPId,
                'productoId'=>$model->productoId,
                'created_at'=>new DateTime(),
                'precio'=>$model->precio,
                'activo'=>$model->activo,
                'listaPid'=>$model->listaPid,
                'listapreciosId'=>$model->listapreciosId
            ]);

            $publicId= $this->db->table(self::TABLE)->where('id',$id)->select('publicId')->first()->publicId;
            return $publicId;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Update lista precios productos
     * @param ListaPreciosProducto $model
     * @return void
     */
    public function update($model){
        if(empty($model->publicId) || empty($model->precio) ) throw new Exception('invalid id');
        $this->db->table(self::TABLE)->where('publicId',$model->publicId)->update([
            'precio'=>$model->precio,
            'activo'=>$model->activo,
            'updated_at'=>new DateTime()
        ]);
    }

    /**
     * Delete lista precios producto
     * @param string $id
     * @return void
     */
    public function delete($id){
        if(empty($id)) throw new Exception('invalid id');
        $this->db->table(self::TABLE)->where('publicId',$id)->update([
            'fecha_eliminado'=>new DateTime()
        ]);
    }

    /**
     * Get lista precio producto
     * @param string $id
     * @return ListaPreciosProducto
     */
    public function getById($id){
        $info=$this->db->table(self::TABLE)->where('publicId',$id)->whereNull('fecha_eliminado')->select([
            'id',
            'publicId',
            'productoId',
            'created_at',
            'updated_at',
            'fecha_eliminado',
            'precio',
            'activo'
        ])->first();

        $model= $this->mapper->map($info);
        return $model;
    }

    /**
     * Check for list and product relacion exist
     * @param string $productoPId
     * @param string $listPid
     * @return bool
     */
    public function existProductOnList($productoPId,$listPid) :bool{
        return $this->db->table(self::TABLE)->where('productoPId',$productoPId)->where('listaPid',$listPid)->whereNull('fecha_eliminado')->exists();
    }


    public function getProductosPorListaPrecios($listPid){
        if(empty($listPid)) throw new Exception('invalid lista id');
        $info=$this->db->table(self::TABLE)->
                where('listaPid',$listPid)
                ->whereNull('fecha_eliminado')
                ->select([
                    'publicId',
                    'productoPId',
                    'productoId',
                    'listaPid',
                    'listapreciosId',
                    'created_at',
                    'updated_at',
                    'fecha_eliminado',
                    'precio',
                    'activo'
                ])
                ->get();

        $models=[];
        $info->each(function($item) use (&$models){
            $model= $this->mapper->map($item);
            array_push($models,$model);
        });

        return $models;
    }

    public function addProductosAListaPrecios(array $models){
        if(count($models)<=0) throw new Exception('no models found');

        $items=[];
        foreach ($models as $model) {
            $item=[
                'publicId'=>uniqid(),
                'productoPId'=>$model->productoPId,
                'productoId'=>$model->productoId,
                'listaPid'=>$model->listaPid,
                'listapreciosId'=>$model->listapreciosId,
                'created_at'=>new DateTime(),
                'precio'=>$model->precio,
                'activo'=>$model->activo
            ];

            array_push($items,$item);
        }

        $this->db->table(self::TABLE)->insert($items);

        return $items;
    }

    /**
     * Get lista precio producto by lista de precio
     * @param string $listaPid
     * @param string $productoPid
     * @return array|null
     */
    public function getProductoPrecio($listaPid,$productoPid){
        if(empty($listaPid) || empty($productoPid)) throw new Exception('invalid lista or producto');

        $data= $this->db->table(self::TABLE)->where('listaPid',$listaPid)->where('productoPId',$productoPid)->whereNull('fecha_eliminado')
        ->select([
            'publicId',
            'productoPId',
            'productoId',
            'listaPid',
            'listapreciosId',
            'created_at',
            'updated_at',
            'fecha_eliminado',
            'precio',
            'activo'
        ])->get();

        $models=[];
        $data->each(function($item) use (&$models){
            $model= $this->mapper->map($item);
            array_push($models,$model);
        });

        return $models;
    }

    /**
     * Get precios by producto
     * @param string $productoId
     * @return array|null
     */
    public function getProductoPrecios($productoId){
        if(empty($productoId))throw new Exception('invalid producto id');

        $data= $this->db->table(self::TABLE)->where('productoPId',$productoId)->whereNull('fecha_eliminado')
        ->select([
            'publicId',
            'productoPId',
            'productoId',
            'listaPid',
            'listapreciosId',
            'created_at',
            'updated_at',
            'fecha_eliminado',
            'precio',
            'activo'
        ])->get();

        $models=[];
        $data->each(function($item) use (&$models){
            $model= $this->mapper->map($item);
            array_push($models,$model);
        });

        return $models;
        
    }
}
