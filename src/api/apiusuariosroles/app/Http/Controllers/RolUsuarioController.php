<?php

namespace App\Http\Controllers;

use App\Contractors\IMapper;
use App\Contractors\Services\IRolUsuarioService;
use App\Enums\AccionsEnums;
use App\Mappers\RolUsuarioMapper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Test\Constraint\ResponseIsUnprocessable;

final class RolUsuarioController extends Controller
{
    private IRolUsuarioService $service;
    private IMapper $mapper;

    public function __construct(IRolUsuarioService $service,RolUsuarioMapper $mapper) {
        $this->service = $service;
        $this->mapper=$mapper;
    }


    public function addRolUsuario(Request $request){
        try {
            if(!$this->HasAccionsPermit([AccionsEnums::ADD_PERMIT,AccionsEnums::ADD_ROL_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);
            $jsonParsed= json_decode($request->getContent());
            $dto= $this->mapper->reverse($jsonParsed);
            $pid=$this->service->addRolUsuario($dto);
            return new Response($this->stdResponse(data:["publicId"=>$pid]));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function deleteRolUsuario($pid){
        try {
            if(!$this->HasAccionsPermit([AccionsEnums::DELETE_PERMIT,AccionsEnums::DELETE_ROL_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);
            $this->service->deleteRolUsuario($pid);
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function getRolUsuario($pid){
        try {
            if(!$this->HasAccionsPermit([AccionsEnums::READ_PERMIT,AccionsEnums::READ_ROL_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);
            $dto=$this->service->getRolUsuarioById($pid);
            return new Response($this->stdResponse(data:$dto));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }
}
