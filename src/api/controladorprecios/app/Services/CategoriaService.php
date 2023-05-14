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

    public function getCategoria($id){
        try {
            return $this->mapper->reverse($this->repository->getById($id));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getCategorias(string $nombre){
        try {
            $catetorias= $this->repository->searchCategory($nombre,false);
            $dtos=[];
            foreach ($catetorias as $value) {
                array_push($dtos,$this->mapper->reverse($value));
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
}
