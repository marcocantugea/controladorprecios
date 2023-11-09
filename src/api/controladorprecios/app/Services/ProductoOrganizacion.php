<?php 

namespace App\Services;

use App\Contractors\IMapper;
use App\Contractors\Repositories\IProductoOrganizacionRepository;
use App\Contractors\Repositories\IProductosRepository;
use App\Contractors\Services\IProductoOrganizacion;
use App\Contractors\Services\IProductosService;
use App\Contractors\Wrappers\IOrganizacionWrapper;
use App\DTOs\ProductoOrganizacionDTO;
use Exception;

class ProductoOrganizacion implements IProductoOrganizacion
{
    private IProductoOrganizacionRepository $repository;
    private IProductosRepository $productoRepository;
    private IMapper $mapper;
    private IOrganizacionWrapper $organizacionWrapper;

    public function __construct(IProductoOrganizacionRepository $productoOrganizacionRepository,
    IProductosRepository $productoRepository,
    IMapper $mapper,
    IOrganizacionWrapper $organizacionWrapper
    ) {
        $this->repository=$productoOrganizacionRepository;
        $this->productoRepository=$productoRepository;
        $this->mapper= $mapper;
        $this->organizacionWrapper=$organizacionWrapper;
    }

    public function addOrganizacion(string $productoId,ProductoOrganizacionDTO $dto){
        try {
            $productoInfo=$this->productoRepository->getById($productoId)->first();
            if(!isset($productoInfo->id)) throw new Exception('invalid producto');
            if(empty($dto->organizacionId)) throw new Exception('missing organizacion Id');
            return $this->repository->addOrganizacion($productoInfo->id,$dto->organizacionId);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function deleteOrganizacion($publicId){
        try {
            $this->repository->deleteOrganizacion($publicId);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getOrganizaciones(string $productoId){
        try {
            $productoInfo=$this->productoRepository->getById($productoId)->first();
            $data= $this->repository->getOrganizaciones($productoInfo->id);
            $dtos=[];
            $data->each(function($item) use (&$dtos){
                $dto= $this->mapper->reverse($item);
                $dto->organizacion= $this->organizacionWrapper->getOrganizacion($dto->organizacionId);
                array_push($dtos,$dto);
            });

            return $dtos;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
