<?php

namespace App\Http\Controllers;

use App\Contractors\IMapper;
use App\Contractors\Services\IModuloService;
use App\Enums\AccionsEnums;
use App\Mappers\ModuloMapper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class ModulosController extends Controller
{
    private IModuloService $service;
    private IMapper $mapper;

    public function __construct(IModuloService $service,ModuloMapper $mapper) {
        $this->service=$service;
        $this->mapper=$mapper;
    }

    public function getModulos(){
        try {
            if(!$this->HasAccionsPermit([AccionsEnums::READ_PERMIT,AccionsEnums::READ_MODULOS_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);
            $dtos=$this->service->getModulos();
            return new Response($this->stdResponse(data:$dtos));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function addModulo(Request $request){
        try {
            if(!$this->HasAccionsPermit([AccionsEnums::ADD_PERMIT,AccionsEnums::ADD_MODULOS_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);
            $jsonParsed= json_decode($request->getContent());
            if(!isset($jsonParsed->nombre) || !isset($jsonParsed->display)) 
                return new Response($this->stdResponse(false,true,"invalid request"),400);

            $dto= $this->mapper->reverse($jsonParsed);

            $publicId=$this->service->addModulo($dto);
            return new Response($this->stdResponse(data:['publicId'=>$publicId]));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function updateModulo(Request $request,$pid){
        try {
            if(!$this->HasAccionsPermit([AccionsEnums::UPDATE_PERMIT,AccionsEnums::UPDATE_MODULOS_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);
            $jsonParsed= json_decode($request->getContent());
            if(!isset($jsonParsed->nombre) || !isset($jsonParsed->display)) 
                return new Response($this->stdResponse(false,true,"invalid request"),400);

            $dto= $this->mapper->reverse($jsonParsed);
            $dto->publicId=$pid;
            $this->service->updateModulo($dto);
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function deleteModulo($pid){
        try {
            if(!$this->HasAccionsPermit([AccionsEnums::DELETE_PERMIT,AccionsEnums::DELETE_MODULOS_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);
            $this->service->deleteModulo($pid);
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function getModuloById($pid){
        try {
            if(!$this->HasAccionsPermit([AccionsEnums::READ_PERMIT,AccionsEnums::READ_MODULOS_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);
            $dto=$this->service->getModuloById($pid);
            return new Response($this->stdResponse(data:$dto));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function getModulosByRol($rolPid){
        try {
            if(!$this->HasAccionsPermit([AccionsEnums::READ_PERMIT,AccionsEnums::READ_MODULOS_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);
            $dtos=$this->service->getModulosByRol($rolPid);
            return new Response($this->stdResponse(data:$dtos));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }
}
