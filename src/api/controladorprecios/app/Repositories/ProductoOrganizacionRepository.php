<?php 

namespace App\Repositories;

use App\Contractors\Repositories\IProductoOrganizacionRepository;

use DateTime;
use Illuminate\Database\MySqlConnection;
use Exception;

class ProductoOrganizacionRepository implements IProductoOrganizacionRepository
{

    private MySqlConnection $db;
    private const TABLE="productoorganizacion";

    public function __construct(MySqlConnection $db) {
        $this->db = $db;
    }

    public function addOrganizacion(int $productoId,string $organizacionId){
        $exist= $this->db->table($this::TABLE)->where('productoId',$productoId)->where('organizacionId',$organizacionId)->whereNull('fecha_eliminado')->count();
        if($exist>0) throw new Exception('product already added on selected organization');

        $id=$this->db->table($this::TABLE)->insertGetId(
            ['publicId'=>uniqid(),
            'productoId'=>$productoId,
            'organizacionId'=>$organizacionId,
            'created_at'=>new DateTime()]
        );

        $publicId=$this->db->table($this::TABLE)->where('id',$id)->first()->publicId;
        return $publicId;
    }

    public function deleteOrganizacion($publicId){
        $this->db->table($this::TABLE)->where('publicId',$publicId)->whereNull('fecha_eliminado')->update(
            [
                'fecha_eliminado'=>new DateTime()
            ]
        );
    }

    public function getOrganizaciones(int $productoId){
        return $this->db->table('productoorganizacion')->where('productoId',$productoId)->whereNull('fecha_eliminado')
        ->select([
            'publicId',
            'organizacionId',
            'created_at',
            'fecha_eliminado'
        ])->get();
    }
}
