<?php

namespace App\Http\Controllers;

use App\Contractors\IMapper;
use App\Contractors\Services\IRolAccionService;
use App\Enums\AccionsEnums;
use App\Mappers\RolAccionMapper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class RolAccionesController extends Controller
{
    private IRolAccionService $service;
    private IMapper $mapper;

    public function __construct(IRolAccionService $service,RolAccionMapper $mapper) {
        $this->service=$service;
        $this->mapper=$mapper;
    }
    
    public function addRolAccion(Request $request){
        try {
            if(!$this->HasAccionsPermit([AccionsEnums::ADD_PERMIT,AccionsEnums::ADD_ROL_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);
            $jsonParsed= json_decode($request->getContent());
            $dto= $this->mapper->reverse($jsonParsed);
            $pid=$this->service->addRolAccion($dto);
            return new Response($this->stdResponse(data:['publicId'=>$pid]));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function deleteRolAccion($pid){
        try {
            if(!$this->HasAccionsPermit([AccionsEnums::DELETE_PERMIT,AccionsEnums::DELETE_ROL_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);
            $this->service->deleteRolAccion($pid);
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function getRolAccion($pid){
        try {
            if(!$this->HasAccionsPermit([AccionsEnums::READ_PERMIT,AccionsEnums::READ_ROL_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);
            $dto=$this->service->getRolAccion($pid);
            return new Response($this->stdResponse(data:$dto));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function getAccionesPorRol($rolPid){
        try {
            if(!$this->HasAccionsPermit([AccionsEnums::READ_PERMIT,AccionsEnums::READ_ROL_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);
            $dtos=$this->service->getAccionesPorRol($rolPid);
            return new Response($this->stdResponse(data:$dtos));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function getAccionesRoles(){
        try {
            if(!$this->HasAccionsPermit([AccionsEnums::READ_PERMIT,AccionsEnums::READ_ROL_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);
            $dtos=$this->service->getAccionesRoles();
            return new Response($this->stdResponse(data:$dtos));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function addAccionesARol(Request $request){
        try {
            if(!$this->HasAccionsPermit([AccionsEnums::ADD_PERMIT,AccionsEnums::ADD_ROL_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);
            $jsonParsed= json_decode($request->getContent());
            if(!is_array($jsonParsed)) return new Response($this->stdResponse(false,true,'invalid request'),400);
            $dtos=[];
            array_walk($jsonParsed,function($item) use (&$dtos){
                $dto=$this->mapper->reverse($item);
                if(!empty($dto)) array_push($dtos,$dto);
            });

            $publicIds=$this->service->addAccionesARol($dtos);
            return new Response($this->stdResponse(data:['publicIds'=>$publicIds]));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }
}
