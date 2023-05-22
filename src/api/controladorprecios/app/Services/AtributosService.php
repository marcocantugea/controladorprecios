<?php 

namespace App\Services;

use App\Contractors\IMapper;
use App\Contractors\Repositories\IAtributoRepository;
use App\Contractors\Services\IAtributosService;
use App\Repositories\AtributosRepository;

class AtributosService  implements IAtributosService
{
    private IAtributoRepository $repository;
    private IMapper $mapper;

    public function __construct(IAtributoRepository $atributoRepository, IMapper $atritbutoMapper) {
        $this->repository=$atributoRepository;
        $this->mapper= $atritbutoMapper;
    }

    public function addAtributo($atributoDto){
        try {
            $this->repository->add($this->mapper->map($atributoDto));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function updateAtributo($atributoDto){
        try {
            $this->repository->update($this->mapper->map($atributoDto));
        } catch (\Throwable $th) {
                throw $th;
        }
    }

    public function deleteAtributo($id){
        try {
            $this->repository->delete($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getAtributo($id){
        try {
            $atributo = $this->repository->getById($id);
            return $this->mapper->map($atributo);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getAtributos(array $serachParams){
        try {
            $validSearchParams=[
                'atributo',
                'activo',
                'publicId',
                'esSubatributo'
            ];
            $searchParameters=[];
            foreach ($serachParams   as $key => $value) {
                if(!in_array($key,$validSearchParams)) continue;
                $searchParameters+=[$key=>$value];
            }

            $itemsFound= $this->repository->searchAtributos($searchParameters);
            $listDtos=[];
            foreach ($itemsFound as $value) {
                $listDtos[]=$this->mapper->reverse($value);
            }
            
            return $listDtos;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
