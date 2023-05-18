<?php

namespace App\Repositories;

use App\Contractors\Models\Categoria;
use App\Contractors\Repositories\ICategoriaRepository;
use App\DTOs\CategoriaDTO;
use Illuminate\Database\MySqlConnection;
use Exception;
use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;

class CategoriaRepository implements ICategoriaRepository
{
    private MySqlConnection $db;

    public function __construct(MySqlConnection $db) {
        $this->db = $db;
    }

    public function add($model)
    {
        if(!$model instanceof Categoria) throw new Exception("model is not instance of categoria", 1);
        $this->db->table('categorias')->insert(
            [
                'publicId'=> uniqid(),
                'nombre'=>$model->nombre,
                'created_at'=>new DateTime('now')
            ]
        );
    }

    public function delete($id)
    {
        if(empty($id)) throw new Exception("invalid categoria id", 1);
        $this->db->table('categorias')->where('publicId',$id)
        ->update([
            'activo'=>false,
            'fecha_eliminado'=> new DateTime('now')
        ]);
    }

    public function getById($id)
    {
        if(empty($id)) throw new Exception("invalid categoria id", 1);
        return $this->db->table('categorias')
        ->where('publicId',$id)
        ->select(
            'publicId',
            'nombre',
            'activo',
            'created_at',
            'updated_at',
            'fecha_eliminado',
            'esSubcategoria'
        )->get()[0];
    }

    public function update($model)
    {
        if(!$model instanceof Categoria) throw new Exception("model is not instance of Categoria", 1);
        if(empty($model->publicId)) throw new Exception("invalid categoria id", 1);
        $this->db->table('categorias')->where('publicId',$model->publicId)
        ->update([
            'nombre'=>$model->nombre,
            'updated_at'=>new DateTime('now')
        ]);
    }

    public function searchCategory(string $nombre,bool $esSubcategoria=false){
        $query=$this->db->table('categorias')->where('esSubcategoria',$esSubcategoria);
        if(!empty($nombre)) $query->where('nombre','like',$nombre,true);
        $query->select(
                        'publicId',
                        'nombre',
                        'activo',
                        'created_at',
                        'updated_at',
                        'fecha_eliminado'
        );

        return $query->get();
    }

    public function addSubCategoria($id,Categoria $model)
    {
        if(!$model instanceof Categoria) throw new Exception("model is not instance of categoria", 1);
        $model->publicId=uniqid();
        $this->db->table('categorias')->insert(
            [
                'publicId'=> $model->publicId,
                'nombre'=>$model->nombre,
                'created_at'=>new DateTime('now'),
                'esSubcategoria'=>true
            ]
        );

        $idCategoria=  $this->db->table('categorias')->where('publicId',$id)->get('id')[0]->id;
        $idSubCategoria= $this->db->table('categorias')->where('publicId',$model->publicId)->get('id')[0]->id;

        $this->db->table('subcategorias')->insert(
            ['categoriaId'=>$idCategoria,'subcategoriaId'=>$idSubCategoria]
        );

    }

    public function addSubCategorias($id, array $CategoriasModel){

        $idCategoria=$this->db->table('categorias')->where('publicId',$id)->get('id')[0]->id;

        foreach ($CategoriasModel as $value) {
            if(!$value instanceof Categoria) throw new Exception('item on array is not a Categorias DTO');
            $value->publicId=uniqid();
            $value->id=$this->db->table('categorias')->insertGetId(
                [
                    'publicId'=> $value->publicId,
                    'nombre'=>$value->nombre,
                    'created_at'=>new DateTime('now'),
                    'esSubcategoria'=>true
                ]
            );

            $this->db->table('subcategorias')->insert(
                [
                    'categoriaId'=>$idCategoria,
                    'subcategoriaId'=>$value->id
                ]
                );
        }
    }

    public function getSubCategoria($id) {
        return $this->db->table('subcategorias')
                            ->join('categorias as catPadre','subcategorias.categoriaId','catPadre.Id')
                            ->join('categorias as catHija','subcategorias.subcategoriaId','catHija.Id')
                            ->where('catPadre.publicId',$id)
                            ->select([
                                'catHija.publicId',
                                'catHija.nombre',
                                'catHija.activo',
                                'catHija.created_at',
                                'catHija.updated_at',
                                'catHija.fecha_eliminado'
                            ])
                            ->get();
    }

    public function hasSubCategorias($id) : bool{
        return  ($this->db->table('subcategorias')
                            ->join('categorias as catPadre','subcategorias.categoriaId','catPadre.Id')
                            ->where('catPadre.publicId',$id)
                            ->count()>0);
    }
}
