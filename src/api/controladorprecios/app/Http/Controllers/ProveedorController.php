<?php

namespace App\Http\Controllers;

use App\Contractors\IMapper;
use App\Contractors\Services\IProveedoresService;
use App\DTOs\ProveedorDTO;
use App\Mappers\ProveedorInfoBasicMapper;
use App\Mappers\ProveedorMapper;
use App\Services\ProveedoresService;
use App\Services\ServicesContainer;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class ProveedorController extends BaseController{

    private IProveedoresService $service;
    private IMapper $mapper;
    private IMapper $proveedorBasicInfoMapper;

    public function __construct() {
        $this->service= ServicesContainer::getService(ProveedoresService::class);
        $this->mapper= ServicesContainer::getService(ProveedorMapper::class);
        $this->proveedorBasicInfoMapper= ServicesContainer::getService(ProveedorInfoBasicMapper::class);
    }


    public function addProveedor(Request $request){
        try {
            $jsonParsed=$this->validateJsonContent($request);
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

}