<?php

namespace App\Services;

use App\Contractors\IMapper;
use App\Contractors\Models\Producto;
use App\Contractors\Repositories\IEquivalenciasRepository;
use App\Contractors\Repositories\IProductosRepository;
use App\Contractors\Services\IEquivalenciasService;
use App\DTOs\EquivalenciaDTO;
use App\DTOs\ProductoDTO;
use Exception;

class EquivalenciasService implements IEquivalenciasService
{
    
    private IProductosRepository $productoRepository;
    private IEquivalenciasRepository $equivalenciaRepository;
    private IMapper $equivalenciaMapper;

    public function __construct(
        IProductosRepository $productoRepository,
        IEquivalenciasRepository $equivalenciaRepository,
        IMapper $equivalenciaMapper
    ) {
        $this->productoRepository=$productoRepository;
        $this->equivalenciaMapper=$equivalenciaMapper;
        $this->equivalenciaRepository=$equivalenciaRepository;
    }

    public function addEquivalencia(EquivalenciaDTO $dto)
    {
        try {
            $dto->productoId = $this->productoRepository->getById($dto->productoPublicId)->first()->id;
            $dto->productoIdEqu = $this->productoRepository->getById($dto->productoPublicIdEqu)->first()->id;
            $model= $this->equivalenciaMapper->map($dto);
            $this->equivalenciaRepository->add($model);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function addEquivalencias(array $equivalencias){
        try {
            array_walk($equivalencias,function($item){
                if(!$item instanceof EquivalenciaDTO) throw new Exception("invalid dto");
                $this->addEquivalencia($item);
            });
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function deleteEquivalencia($id)
    {
        try {
            if(empty($id)) throw new Exception('invalid id');
            $this->equivalenciaRepository->delete($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getEquivalencia($id)
    {
        try {
            $dto= $this->equivalenciaRepository->getById($id)->map(function($item){
                $dto=new EquivalenciaDTO($item->productoPublicId,$item->equivalenciaPublicId,$item->publicId);
                $dto->producto= new ProductoDTO($item->equivalenciaNombre,$item->equivalenciaDescripcion,$item->equivalenciaCodigo,publicId:$item->equivalenciaPublicId);
                return $dto;
            });

            return $dto;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getEquivalenciasByProducto(string $productoId)
    {
        try {
            if(empty($productoId)) throw new Exception("invalid id");
            $dtos=$this->equivalenciaRepository->getEquivalenciasByProducto($productoId)
            ->map(function($item){
                $dto= new EquivalenciaDTO($item->productoPublicId,$item->equivalenciaPublicId,$item->publicId);
                $dto->producto= new ProductoDTO($item->equivalenciaNombre,$item->equivalenciaDescripcion,$item->equivalenciaCodigo,publicId:$item->equivalenciaPublicId);
                return $dto;
            });

            return $dtos;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}
