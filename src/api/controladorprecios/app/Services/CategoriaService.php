<?php 

namespace App\Services;

use App\Contractors\IMapper;
use App\Contractors\Repositories\ICategoriaRepository;
use App\Contractors\Services\ICategoriaService;
use App\DTOs\CategoriaDTO;

class CategoriaService implements ICategoriaService
{
    private ICategoriaRepository $repository;
    private IMapper $mapper;

    public function __construct(ICategoriaRepository $categoriaRepository,IMapper $mapper) {
        $this->repository= $categoriaRepository;
        $this->mapper= $mapper;
    }

    public function addCategoria(CategoriaDTO $dto){
        try {
            $categoriaModel= $this->mapper->map($dto);
            $this->repository->add($categoriaModel);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function updateCategoria(CategoriaDTO $dto){
        try {
            $categoriaModel= $this->mapper->map($dto);
            $this->repository->update($categoriaModel);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function deleteCategoria($id){
        try {
            $this->repository->delete($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getCategoria($id,bool $addSubCategorias=false){
        try {
            $categoriaDto=$this->mapper->reverse($this->repository->getById($id));
            if($this->repository->hasSubCategorias($id)) $categoriaDto->subcategoria= $this->getSubCategorias($id,$addSubCategorias);
            return $categoriaDto;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getCategorias(string $nombre,bool $addSubCategorias=false){
        try {
            $catetorias= $this->repository->searchCategory($nombre,false);
            $dtos=[];
            foreach ($catetorias as $value) {
                $categoria=$this->mapper->reverse($value);
                if($this->repository->hasSubCategorias($categoria->publicId)) $categoria->subcategoria=$this->getSubCategorias($categoria->publicId,$addSubCategorias);
                array_push($dtos,$categoria);
            }
            return $dtos;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function addSubCategoria($id,CategoriaDTO $subCategoria){
        try {
            $categoriaModel= $this->mapper->map($subCategoria);
            $this->repository->addSubCategoria($id,$categoriaModel);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function addSubCategorias($id,array $subCategoriasDTO){
        try {
            $subcategorias=[];
            foreach ($subCategoriasDTO as $value) {
                if(!$value instanceof CategoriaDTO) throw new \Exception("invalid item categoria ");
                
                $subcategorias[]=$this->mapper->map($value);
            }
            $this->repository->addSubCategorias($id,$subcategorias);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getSubCategorias($id,bool $loadChilds=false):array{
        try {
            $subcategoriasFound=$this->repository->getSubCategoria($id);
            $subcategoriasDto=[];
            foreach ($subcategoriasFound as $value) {
                $item=$this->mapper->reverse($value);
                if($this->repository->hasSubCategorias($item->publicId) && $loadChilds){
                    $subCategoriasHijos=$this->getSubCategorias($item->publicId,$loadChilds);
                    $item->subcategoria=$subCategoriasHijos;
                }
                $subcategoriasDto[]=$item;
            }
            return $subcategoriasDto;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
