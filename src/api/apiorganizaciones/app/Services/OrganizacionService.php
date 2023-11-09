<?php

namespace App\Services;

use App\Contractors\IMapper;
use App\DTOs\OrganizacionDTO;
use App\Repositories\OrganizacionRepository;
use App\Mappers\OrganizacionMapper;

class OrganizacionService
{
    private OrganizacionRepository $repository;
    private OrganizacionMapper $mapper;

    public function __construct(OrganizacionRepository $repo,OrganizacionMapper $mapper) {
        $this->repository = $repo;
        $this->mapper=$mapper;
    }

    public function addOrganizacion(OrganizacionDTO $dto){
        try {
            $model= $this->mapper->map($dto);
            $publicId=$this->repository->addOrganizacion($model);
            return $publicId;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getOrganizacion(string $publicId){
        try {
            $data= $this->repository->getOrganizacion($publicId);
            $dto= $this->mapper->reverse($data);
            return $dto;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function deleteOrganizacion(string $pubicId){
        try {
            $this->repository->deleteOrganizacion($pubicId);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getOrganizaciones(){
        try {
            $data=$this->repository->getOrganizaciones();
            $dtos=[];
            $data->each(function($item) use (&$dtos) {
                array_push($dtos, $this->mapper->reverse($item));
            });

            return $dtos;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
