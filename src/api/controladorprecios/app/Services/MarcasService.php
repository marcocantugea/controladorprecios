<?php

namespace App\Services;

use App\Contractors\IMapper;
use App\Contractors\Repositories\IMarcaRepository;
use App\Contractors\Services\IMarcasService;
use App\DTOs\MarcaDTO;

class MarcasService  implements IMarcasService
{

    private IMapper $mapper;
    private IMarcaRepository $repository;

    public function __construct(IMarcaRepository $marcaRepository,IMapper $mapper) {
        $this->mapper=$mapper;
        $this->repository=$marcaRepository;
    }

    public function addMarca(MarcaDTO $marcaDto){
        try {
            $model=$this->mapper->map($marcaDto);
            $this->repository->add($model);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function updateMarca(MarcaDTO $marcaDTO){
        try {
            $model=$this->mapper->map($marcaDTO);
            $this->repository->update($model);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function deleteMarca($id){
        try {
            $this->repository->delete($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getMarca($id){
        try {
            return $this->mapper->reverse($this->repository->getById($id));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getMarcas(array $searchParams){
        try {
            $validSearchParams=[
                'marcas',
                'activo',
                'publicId',
            ];
            $searchParameters=[];
            foreach ($searchParams   as $key => $value) {
                if(!in_array($key,$validSearchParams)) continue;
                $searchParameters+=[$key=>$value];
            }

            $itemsFound= $this->repository->getMarcas($searchParameters);
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
