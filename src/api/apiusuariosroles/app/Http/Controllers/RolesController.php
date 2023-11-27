<?php

namespace App\Http\Controllers;

use App\Contractors\IMapper;
use App\Contractors\Services\IRolService;
use App\Enums\AccionsEnums;
use App\Mappers\RolMapper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class RolesController extends Controller
{
    private IMapper $mapper;
    private IRolService $service;

    public function __construct(IRolService $service, RolMapper $mapper) {
        $this->service=$service;
        $this->mapper=$mapper;
    }

    public function addRol(Request $request){
        try {
            if(!$this->HasAccionsPermit([AccionsEnums::ADD_PERMIT,AccionsEnums::ADD_ROL_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);
            $jsonParsed= json_decode($request->getContent());
            $dto= $this->mapper->reverse($jsonParsed);
            $pid=$this->service->addRole($dto);
            return new Response($this->stdResponse(data:["publicId"=>$pid]));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function updateRol($pid,Request $request){
        try {
            if(!$this->HasAccionsPermit([AccionsEnums::UPDATE_PERMIT,AccionsEnums::UPDATE_ROL_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);

            $jsonParsed= json_decode($request->getContent());
            $dto= $this->mapper->reverse($jsonParsed);
            $dto->publicId=$pid;
            $this->service->updateRol($dto);
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function deleteRol($pid){
        try {
            if(!$this->HasAccionsPermit([AccionsEnums::DELETE_PERMIT,AccionsEnums::DELETE_ROL_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);
            $this->service->deleteRol($pid);
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function getRol($pid){
        try {
            if(!$this->HasAccionsPermit([AccionsEnums::READ_PERMIT,AccionsEnums::READ_ROL_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);
            $data=$this->service->getRol($pid);
            return new Response($this->stdResponse(data:$data));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }


    public function getRoles(){
        try {
            if(!$this->HasAccionsPermit([AccionsEnums::READ_PERMIT,AccionsEnums::READ_ROL_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);
            $data=$this->service->getRoles();
            return new Response($this->stdResponse(data:$data));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }
}
