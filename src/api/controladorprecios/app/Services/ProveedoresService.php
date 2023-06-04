<?php

namespace App\Services;

use App\Contractors\IMapper;
use App\Contractors\Models\Proveedor;
use App\Contractors\Models\ProveedorInfoBasic;
use App\Contractors\Repositories\IMarcaRepository;
use App\Contractors\Repositories\IProveedorRepository;
use App\Contractors\Services\IProveedoresService;
use App\DTOs\ProveedorDTO;
use App\DTOs\ProveedorInfoBasicDTO as DTOsProveedorInfoBasicDTO;
use App\DTOs\ProveedorMarcaDTO;
use Exception;

class ProveedoresService  implements IProveedoresService
{
    private IProveedorRepository $repository;
    private IMapper $proveedorMapper;
    private IMapper $proveedorInfoBasicMapper;
    private IMapper $proveedorMarcaMapper;
    private IMarcaRepository $marcaRepository;

    public function __construct(IProveedorRepository $repository,
    IMapper $proveedorMapper, 
    IMapper $proveedorInfoBasicMapper, 
    IMapper $proveedorMarcaMapper,
    IMarcaRepository $marcaRepository
    ) {
        $this->repository=$repository;
        $this->proveedorMapper=$proveedorMapper;
        $this->proveedorInfoBasicMapper=$proveedorInfoBasicMapper;
        $this->proveedorMarcaMapper=$proveedorMarcaMapper;
        $this->marcaRepository=$marcaRepository;
    }

    public function addProveedor(ProveedorDTO $proveedor){
        try {
            $model= $this->proveedorMapper->map($proveedor);
            $this->repository->add($model);
            $proveedor=$this->repository->getProveedorByCode($model->codigo);
            return $this->proveedorMapper->reverse($proveedor);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function addProveedorInfoBasic(DTOsProveedorInfoBasicDTO $proveedorInfoBasic){
        try {
            $model=$this->proveedorInfoBasicMapper->map($proveedorInfoBasic);
            if(empty($proveedorInfoBasic->proveedor)) throw new Exception("no proveedor info found on request");
            if(empty($proveedorInfoBasic->proveedor->publicId)) throw new Exception("invalid proveedor id");
            $idProveedor= $this->repository->getById($proveedorInfoBasic->proveedor->publicId)->id;
            $model->proveedorId=$idProveedor;
            $this->repository->addProveedorInfoBasic($model);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function updateProveedor(ProveedorDTO $proveedor){
        try {
            $model= $this->proveedorMapper->map($proveedor);
            $this->repository->update($model);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function updateProveedorBasicInfo(DTOsProveedorInfoBasicDTO $dto){
        try {
            $model= $this->proveedorInfoBasicMapper->map($dto);
            $this->repository->updateProveedorInfoBasic($model);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function deleteProveedor($id){
        try {
            $this->repository->delete($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function deleteProveedorInfoBasic($id){
        try {
            $this->repository->deleteProveedorInfoBasic($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getProveedor($id){
        try {
            $proveedorModel=$this->repository->getById($id);
            if(empty($proveedorModel)) throw new Exception("no found");
            $proveedor=$this->proveedorMapper->reverse($proveedorModel);
            $proveedor->infoBasic=$this->proveedorInfoBasicMapper->reverse($this->repository->getInfoBasicByProveedor($proveedorModel->publicId));
            return $proveedor;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getProveedores(array $searchParams, int $limit=500,int $offset=0,bool $showDeleted=true){
        try {
            
            $likefields=[
                'codigo',
                'nombreCorto',
                'nombre',
                'rasonSocial',
                'RFC'
            ];

            $modelProveedor=get_class_vars(Proveedor::class);
            $modelBasicInfo=get_class_vars(ProveedorInfoBasic::class);
            $table='proveedores';
            $filterSearchParams=[];
            foreach ($searchParams as $key => [$value,$operator]) {
                if(!in_array($key,array_keys($modelProveedor)) && !in_array($key,array_keys($modelBasicInfo)) ) continue;  
                if(in_array($key,array_keys($modelBasicInfo))){
                    $table='proveedoresInfoBasic';
                }
                if(in_array($key,$likefields)) $operator='like';
                $filterKey=$table.".".$key;
                $filterSearchParams+=[$filterKey=>[$value,$operator]];
            }

            $itemsFound= $this->repository->getProveedores($filterSearchParams,$limit,$offset,$showDeleted)->map(function($item){
                $proveedorModel= new Proveedor($item->codigo,
                                            $item->nombreCorto,
                                            $item->proveedorId,
                                            $item->proveedorPublicId,
                                            $item->proveedorActivo,
                                            $item->proveedorCreated_at,
                                            $item->proveedorUpdated_at,
                                            $item->ProveedorFecha_eliminado);
                if(!empty($item->nombre)){
                $proveedorModel->infoBasic=new ProveedorInfoBasic($item->nombre,
                                                                    $item->rasonSocial,
                                                                    $item->RFC,
                                                                    $item->infoBasicId,
                                                                    $item->infoBasicPublicId,
                                                                    $item->infoBasicActivo,
                                                                    $item->infoBasicCreated_at,
                                                                    $item->infoBasicUpdated_at,
                                                                    $item->infoBasicFecha_eliminado);
                }
                $proveedor=$this->proveedorMapper->reverse($proveedorModel);
                if(!empty($item->nombre)) $proveedor->infoBasic = $this->proveedorInfoBasicMapper->reverse($proveedorModel->infoBasic);

                return $proveedor;
            });

            $response=[
                'offset'=>$offset,
                'limit'=>$limit,
                'totalRecordsFound'=>count($itemsFound),
                'data'=>$itemsFound
            ];

            return $response;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function addProveedorMarca(ProveedorMarcaDTO $proveedorMarca){
        try {
            $proveedorMarca->proveedorId= $this->repository->getById($proveedorMarca->proveedorPublicId)->id;
            $proveedorMarca->marcaId=$this->marcaRepository->getById($proveedorMarca->marca->publicId)->id;
            $model=$this->proveedorMarcaMapper->map($proveedorMarca);
            if(empty($model)) throw new Exception("invalid model creation");
            $this->repository->addProveedorMarca($model);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function addProveedorMarcas(array $proveedorMarcas){
        try {
            array_walk($proveedorMarcas,function($item){
                if(!$item instanceof ProveedorMarcaDTO) throw new Exception("invalid value proveedor marca");
                $this->addProveedorMarca($item);
            });
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getMarcasByProveedor(string $proveedorId){
        try {
            $items=$this->repository->getMarcasByProveedor($proveedorId)->map(function($item) use($proveedorId){
                return new ProveedorMarcaDTO($proveedorId,$item->marcaPublicId,$item->marca);
            });
            return $items;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
