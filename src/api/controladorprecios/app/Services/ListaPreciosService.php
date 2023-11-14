<?php

namespace App\Services;

use App\Contractors\IMapper;
use App\Contractors\Repositories\IListaPreciosRepository;
use App\Contractors\Services\IListaPreciosService;
use App\DTOs\ListaPreciosDTO;

final class ListaPreciosService implements IListaPreciosService
{
    private IListaPreciosRepository $repository;
    private IMapper $mapper;

    public function __construct(IMapper $mapper, IListaPreciosRepository $repository) {
        $this->repository=$repository;
        $this->mapper=$mapper;
    }

    /**
     * Add lista precios
     * @param ListaPreciosDTO $dto
     * @return void
     */
    public function addListaPrecios($dto){
        try {
            $model= $this->mapper->map($dto);
            $this->repository->add($model);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Update Lista de precios
     * @param ListaPreciosDTO $dto
     * @return void
     */
    public function updateListaPrecios($dto){
        try {
            $model= $this->mapper->map($dto);
            $this->repository->update($model);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Delete lista de precio
     * @param string $id
     * @return void
     */
    public function deleteListaPrecios($id){
        try {
            $this->repository->delete($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    /**
     * Get Lista de Precio
     * @param string $id
     * @return void
     */
    public function getListaPreciosById($id){
        try {
            $model= $this->repository->getById($id);
            $dto= $this->mapper->reverse($model);

            return $dto;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Get all listas de precios
     * @return array|null
     */
    public function getListasPrecios(): array
    {
        try {
            $models= $this->repository->getListasPrecios();
            $dtos=[];
            
            foreach ($models as $item) {
                $dto= $this->mapper->reverse($item);
                array_push($dtos,$dto);
            }

            return $dtos;
        } catch (\Throwable $th) {
            throw $th;
        }   
    }

}
