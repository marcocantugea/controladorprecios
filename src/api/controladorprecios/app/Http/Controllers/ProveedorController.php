<?php

namespace App\Http\Controllers;

use App\Contractors\IMapper;
use App\Contractors\Models\ProveedorMarca;
use App\Contractors\Services\IProveedoresService;
use App\DTOs\ProveedorDTO;
use App\Mappers\ProveedorInfoBasicMapper;
use App\Mappers\ProveedorMapper;
use App\Mappers\ProveedorMarcaMapper;
use App\Mappers\ProveedorProductoMapper;
use App\Services\ProveedoresService;
use App\Services\ServicesContainer;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class ProveedorController extends BaseController{

    private IProveedoresService $service;
    private IMapper $mapper;
    private IMapper $proveedorBasicInfoMapper;
    private IMapper $proveedorMarcaMapper;
    private IMapper $proveedorProductoMapper;

    public function __construct(
        IProveedoresService $service,
        ProveedorMapper $mapper,
        ProveedorInfoBasicMapper $proveedorBasicInfoMapper,
        ProveedorMarcaMapper $proveedorMarcaMapper,
        ProveedorProductoMapper $proveedorProductoMapper
    ) {
        $this->service= $service;
        $this->mapper= $mapper;
        $this->proveedorBasicInfoMapper= $proveedorBasicInfoMapper;
        $this->proveedorMarcaMapper=$proveedorMarcaMapper;
        $this->proveedorProductoMapper=$proveedorProductoMapper;
    }


    public function addProveedor(Request $request){
        try {
            $jsonParsed=$this->validateJsonContent($request);
            if($jsonParsed instanceof Response) return $jsonParsed;
            $dto= $this->mapper->reverse($jsonParsed);
            if(empty($dto))  return new Response($this->stdResponse(false,true,"no valid content"),400);
            $proveedor=$this->service->addProveedor($dto);
            return new Response($this->stdResponse(data:$proveedor));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function addProveedorBasicInfo(Request $request, $id){
        try {
            $jsonParsed=$this->validateJsonContent($request);
            if($jsonParsed instanceof Response) return $jsonParsed;
            $dto= $this->proveedorBasicInfoMapper->reverse($jsonParsed);
            if(empty($dto))  return new Response($this->stdResponse(false,true,"no valid content"),400);
            $dto->proveedor= new ProveedorDTO("","",publicId:$id);
            $this->service->addProveedorInfoBasic($dto);
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function updateProveedor(Request $request,$id){
        try {
            $jsonParsed=$this->validateJsonContent($request);
            if($jsonParsed instanceof Response) return $jsonParsed;
            $dto= $this->mapper->reverse($jsonParsed);
            if(empty($dto))  return new Response($this->stdResponse(false,true,"no valid content"),400);
            $dto->publicId=$id;
            $this->service->updateProveedor($dto);
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function updateProveedorInfoBasic(Request $request, $id){
        try {
            $jsonParsed=$this->validateJsonContent($request);
            if($jsonParsed instanceof Response) return $jsonParsed;
            $dto= $this->proveedorBasicInfoMapper->reverse($jsonParsed);
            if(empty($dto))  return new Response($this->stdResponse(false,true,"no valid content"),400);
            $dto->publicId=$id;
            $this->service->updateProveedorBasicInfo($dto);
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function deleteProveedor($id){
        try {
            if(empty($id)) return new Response($this->stdResponse(false,true,"no valid content"),400);
            $this->service->deleteProveedor($id);
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function deleteProveedorBasicInfo($id){
        try {
            if(empty($id)) return new Response($this->stdResponse(false,true,"no valid content"),400);
            $this->service->deleteProveedorInfoBasic($id);
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function getProveedor($id){
        try {
            if(empty($id)) return new Response($this->stdResponse(false,true,"no valid content"),400);
            $proveedor=$this->service->getProveedor($id);
            return new Response($this->stdResponse(data:$proveedor));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function getProveedores(Request $request){
        $searchParams= $request->query();
        try {
            $productosSearchParams=[];
            $limit=500;
            $offset=0;
            $showDelete=true;
            foreach ($searchParams as $key => $value) {
                if($key=='offset') {
                    $offset=$value;
                    continue;
                }

                if($key=='limit'){
                    $limit=$value;
                    continue;
                }

                if($key=='showDeleted'){
                    $showDelete=boolval($value);
                    continue;
                }

                $productosSearchParams+=[$key=>[$value,null]];
            }

            $productosFound=$this->service->getProveedores($productosSearchParams,$limit,$offset,$showDelete);

            return new Response($this->stdResponse(data:$productosFound));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function updatePropiedadesProveedor(Request $request,$id){

        try {
            $jsonParsed=$this->validateJsonContent($request);
            if($jsonParsed instanceof Response) return $jsonParsed;
            if(isset($jsonParsed->marcas)){
                $dtos=[];
                foreach ($jsonParsed->marcas as $value) {
                    $value->proveedorPublicId=$id;
                    $dto=$this->proveedorMarcaMapper->reverse($value);
                    if(empty($dto)) continue;
                    array_push($dtos,$dto);
                }
                
                if(empty($dto)) return new Response($this->stdResponse(false,true,"no valid content"),400);
                $this->service->addProveedorMarcas($dtos);
            }

            if(isset($jsonParsed->productos)){
                $dtos=[];
                foreach ($jsonParsed->productos as $value) {
                    $value->proveedorPublicId=$id;
                    $dto=$this->proveedorProductoMapper->reverse($value);
                    if(empty($dto)) continue;
                    array_push($dtos,$dto);
                }
                
                if(empty($dto)) return new Response($this->stdResponse(false,true,"no valid content"),400);
                $this->service->addProveedorProductos($dtos);
            }
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function getMarcasProveedor($id){
        try {
            if(empty($id)) return new Response($this->stdResponse(false,true,"no valid content"),400);
            $items=$this->service->getMarcasByProveedor($id);
            return new Response($this->stdResponse(data:$items));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function deleteProveedorMarcas(Request $request,$id){
        try {
            $jsonParsed=$this->validateJsonContent($request);
            if($jsonParsed instanceof Response) return $jsonParsed;
            if(isset($jsonParsed->marcas)){
                $dtos=[];
                foreach ($jsonParsed->marcas as $value) {
                    $value->proveedorPublicId=$id;
                    $dto=$this->proveedorMarcaMapper->reverse($value);
                    if(empty($dto)) continue;
                    array_push($dtos,$dto);
                }
                
                if(empty($dto)) return new Response($this->stdResponse(false,true,"no valid content"),400);
                $this->service->deleteProveedorMarcas($dtos);
                return new Response($this->stdResponse());
            }
            
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function deleteProveedorProducto(Request $request, $id){
        try {
            $jsonParsed=$this->validateJsonContent($request);
            if($jsonParsed instanceof Response) return $jsonParsed;
            if(isset($jsonParsed->productos)){
                $dtos=[];
                foreach ($jsonParsed->productos as $value) {
                    $value->proveedorPublicId=$id;
                    $dto=$this->proveedorProductoMapper->reverse($value);
                    if(empty($dto)) continue;
                    array_push($dtos,$dto);
                }
                
                if(empty($dto)) return new Response($this->stdResponse(false,true,"no valid content"),400);
                $this->service->deleteProveedorProductos($dtos);
                return new Response($this->stdResponse());
            }
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function getProveedorProductos(Request $request,$id){
        try {
            if(empty($id)) return new Response($this->stdResponse(false,true,"no valid content"),400);
            $limit=500;
            $offset=0;
            if(null!=$request->query('limit')) $limit=$request->query('limit');
            if(null != $request->query('offset')) $offset=$request->query('offset');
            $items=$this->service->getProveedorProductos($id,$limit,$offset);
            return new Response($this->stdResponse(data:$items));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }
}