<?php

namespace App\Http\Controllers;

use App\Contractors\IMapper;
use App\Contractors\Services\ICostosService;
use App\Mappers\CostoMapper;
use App\Services\CostosService;
use App\Services\ServicesContainer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CostoController extends BaseController
{
    private IMapper $mapper;
    private ICostosService $service;

    public function __construct() {
        $this->mapper= ServicesContainer::getService(CostoMapper::class);
        $this->service= ServicesContainer::getService(CostosService::class);
    }

    public function addCosto(Request $request){
        try {
            $jsonParsed=$this->validateJsonContent($request);
            if($jsonParsed instanceof Response) return $jsonParsed;
            $dto=$this->mapper->reverse($jsonParsed);
            if(empty($dto)) new Response($this->stdResponse(false,true,"invalid content"),400);
            $this->service->addCosto($dto);
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()));
        }
    }

    public function addCostos(Request $request){
        try {
            $jsonParsed=$this->validateJsonContent($request);
            if($jsonParsed instanceof Response) return $jsonParsed;
            if(!is_array($jsonParsed)) new Response($this->stdResponse(false,true,"invalid content"),400);
            $dtos=[];
            foreach ($jsonParsed as $value) {
                array_push($dtos,$this->mapper->reverse($value));
            }

            $this->service->addCostos($dtos);
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()));
        }
    }

    public function getCosto($id){
        try {
            return new Response($this->stdResponse(data:$this->service->getCosto($id)));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()));
        }
    }

    public function updateCosto(Request $request, $id){
        try {
            $jsonParsed=$this->validateJsonContent($request);
            if($jsonParsed instanceof Response) return $jsonParsed;
            if(empty($id)) return new Response($this->stdResponse(false,true,"invaid contente"),400);

            $dto=$this->mapper->reverse($jsonParsed);
            if(empty($dto)) new Response($this->stdResponse(false,true,"invalid content"),400);

            $dto->publicId=$id;

            $this->service->updateCosto($dto);
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()));
        }
    }

    public function updateCostos(Request $request){
        try {
            $jsonParsed=$this->validateJsonContent($request);
            if($jsonParsed instanceof Response) return $jsonParsed;
            if(!is_array($jsonParsed)) new Response($this->stdResponse(false,true,"invalid content"),400);
            $dtos=[];
            foreach ($jsonParsed as $value) {
                array_push($dtos,$this->mapper->reverse($value));
            }

            $this->service->updateCostos($dtos);
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()));
        }
    }

    public function deleteCosto($id){
        try {
            $this->service->deleteCosto($id);
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()));
        }
    }

    public function deleteCostos(Request $request){
        try {
            
            $jsonParsed=$this->validateJsonContent($request);
            if($jsonParsed instanceof Response) return $jsonParsed;
            if(!is_array($jsonParsed)) new Response($this->stdResponse(false,true,"invalid content"),400);

            array_walk($jsonParsed,function($item){
                $this->service->deleteCosto($item->publicId);
            });
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()));
        }
    }

    public function getCostosByProveedor($proveedorId){
        try {
            $data = $this->service->getCostosByProveedor($proveedorId);
            return new Response($this->stdResponse(data:$data));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()));
        }
    }
}
