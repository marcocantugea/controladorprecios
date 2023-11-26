<?php

namespace App\Http\Controllers;

use App\Contractors\IMapper;
use App\Contractors\Services\ICostosService;
use App\Enums\AccionsEnums;
use App\Mappers\CostoMapper;
use App\Services\CostosService;
use App\Services\ServicesContainer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CostoController extends BaseController
{
    private IMapper $mapper;
    private ICostosService $service;

    public function __construct(ICostosService $costoService,CostoMapper $mapper) {
        $this->mapper= $mapper;
        $this->service= $costoService;
    }

    public function addCosto(Request $request){
        try {

            if(!$this->HasAccionsPermit([AccionsEnums::ADD_PERMIT,AccionsEnums::ADD_COSTOS_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);
            
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

            if(!$this->HasAccionsPermit([AccionsEnums::ADD_PERMIT,AccionsEnums::ADD_COSTOS_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);

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
            if(!$this->HasAccionsPermit([AccionsEnums::READ_PERMIT,AccionsEnums::READ_COSTOS_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);
            return new Response($this->stdResponse(data:$this->service->getCosto($id)));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()));
        }
    }

    public function updateCosto(Request $request, $id){
        try {
            if(!$this->HasAccionsPermit([AccionsEnums::UPDATE_PERMIT,AccionsEnums::UPDATE_COSTOS_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);
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
            if(!$this->HasAccionsPermit([AccionsEnums::UPDATE_PERMIT,AccionsEnums::UPDATE_COSTOS_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);
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
            if(!$this->HasAccionsPermit([AccionsEnums::DELETE_PERMIT,AccionsEnums::DELETE_COSTOS_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);
            $this->service->deleteCosto($id);
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()));
        }
    }

    public function deleteCostos(Request $request){
        try {
            if(!$this->HasAccionsPermit([AccionsEnums::DELETE_PERMIT,AccionsEnums::DELETE_COSTOS_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);
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
            if(!$this->HasAccionsPermit([AccionsEnums::READ_PERMIT,AccionsEnums::READ_COSTOS_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);
            $data = $this->service->getCostosByProveedor($proveedorId);
            return new Response($this->stdResponse(data:$data));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()));
        }
    }
}
